<?php

namespace App\Controller;

use App\Entity\Bibliotheque;
use App\Entity\Livre;
use App\Form\LivreType;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/livre")
 */
class LivreController extends AbstractController
{
    /**
     * @Route("/", name="app_livre_index", methods={"GET"})
     */
    public function index(Request $request, LivreRepository $livreRepository): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $livres = $livreRepository->findAll();
        } else {
            /** @var \App\Entity\User */
            $user = $this->getUser();
            if ($user) {
                $membre = $user->getMembre();
                $livres = $livreRepository->findMemberLivres($membre);
            } else {
                throw $this->createAccessDeniedException("You cannot access livres without connection!");
            }
        }
        return $this->render('livre/index.html.twig', [
            'livres' => $livres,
        ]);
    }

    /**
     * @Route("/favorite", name="app_livre_index_favorite", methods={"GET"})
     */
    public function indexFavorite(Request $request, LivreRepository $livreRepository): Response
    {
        $urgents = $request->getSession()->get('urgents');
        if ($urgents == null) {
            $urgents = [];
        }
        $livres = $livreRepository->findAll();
        // Filter by id in urgent array
        $livres = array_filter($livres, function ($livre) use ($urgents) {
            return in_array($livre->getId(), $urgents);
        });
        return $this->render('livre/index_favorite.html.twig', [
            'livres' => $livres,
        ]);
    }


    /**
     * @Route("/new/{id}", name="app_livre_new", methods={"GET", "POST"})
     */
    public function new(Request $request, LivreRepository $livreRepository, Bibliotheque $bibliotheque): Response
    {
        $hasAccess = $this->isGranted('ROLE_ADMIN') ||
            ($this->getUser() != null && $this->getUser() == $bibliotheque->getMembre()->getUser());
        if (!$hasAccess) {
            throw $this->createAccessDeniedException("You cannot edit another member's bibliotheque livre!");
        }

        $livre = new Livre();
        $livre->setBibliotheque($bibliotheque);
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $livreRepository->add($livre, true);
            $this->addFlash('message', 'bien ajouté');

            return $this->redirectToRoute('app_bibliotheque_show', ['id' => $bibliotheque->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('livre/new.html.twig', [
            'livre' => $livre,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_livre_show", methods={"GET"})
     */
    public function show(Livre $livre): Response
    {
        $hasAccess = $this->isGranted('ROLE_ADMIN') ||
            ($this->getUser() != null && $this->getUser() == $livre->getBibliotheque()->getMembre()->getUser());
        if (!$hasAccess) {
            throw $this->createAccessDeniedException("You cannot view another member's bibliotheque livre in private!");
        }

        return $this->render('livre/show.html.twig', [
            'livre' => $livre,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_livre_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Livre $livre, LivreRepository $livreRepository): Response
    {
        $hasAccess = $this->isGranted('ROLE_ADMIN') ||
            ($this->getUser() != null && $this->getUser() == $livre->getBibliotheque()->getMembre()->getUser());
        if (!$hasAccess) {
            throw $this->createAccessDeniedException("You cannot edit another member's bibliotheque livre in private!");
        }

        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $livreRepository->add($livre, true);

            return $this->redirectToRoute('app_bibliotheque_show', ['id' => $livre->getBibliotheque()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('livre/edit.html.twig', [
            'livre' => $livre,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_livre_delete", methods={"POST"})
     */
    public function delete(Request $request, Livre $livre, LivreRepository $livreRepository): Response
    {
        $hasAccess = $this->isGranted('ROLE_ADMIN') ||
            ($this->getUser() != null && $this->getUser() == $livre->getBibliotheque()->getMembre()->getUser());
        if (!$hasAccess) {
            throw $this->createAccessDeniedException("You cannot delete another member's bibliotheque livre in private!");
        }

        if ($this->isCsrfTokenValid('delete' . $livre->getId(), $request->request->get('_token'))) {
            $livreRepository->remove($livre, true);
        }

        return $this->redirectToRoute('app_bibliotheque_show', ['id' => $livre->getBibliotheque()->getId()], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/livre/favorite/{id_livre}", name="app_livre_toogle_favorite", methods={"POST"})
     * @ParamConverter("livre", options={"id" = "id_livre"})
     */
    public function toogleFavorite(Request $request, Livre $livre): Response
    {
        $urgents = $request->getSession()->get('urgents');
        if (!is_array($urgents)) {
            $urgents = array();
        }
        if (in_array($livre->getId(), $urgents)) {
            $urgents = array_diff($urgents, [$livre->getId()]);
        }

        $request->getSession()->set('urgents', $urgents);

        return $this->redirectToRoute('app_livre_index_favorite', [], Response::HTTP_SEE_OTHER);
    }
}