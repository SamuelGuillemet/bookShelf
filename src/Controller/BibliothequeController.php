<?php

namespace App\Controller;

use App\Entity\Bibliotheque;
use App\Entity\Membre;
use App\Form\BibliothequeType;
use App\Repository\BibliothequeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/bibliotheque")
 */
class BibliothequeController extends AbstractController
{
    /**
     * @Route("/", name="app_bibliotheque_index", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(BibliothequeRepository $bibliothequeRepository): Response
    {
        return $this->render('bibliotheque/index.html.twig', [
            'bibliotheques' => $bibliothequeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="app_bibliotheque_new", methods={"GET", "POST"})
     */
    public function new(Request $request, BibliothequeRepository $bibliothequeRepository, Membre $membre): Response
    {
        $hasAccess = $this->isGranted('ROLE_ADMIN') ||
            ($this->getUser() != null && $this->getUser() == $membre->getUser());
        if (!$hasAccess) {
            throw $this->createAccessDeniedException("You cannot create another member's bibliotheque!");
        }

        $bibliotheque = new Bibliotheque();
        $bibliotheque->setMembre($membre);
        $form = $this->createForm(BibliothequeType::class, $bibliotheque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bibliothequeRepository->add($bibliotheque, true);

            return $this->redirectToRoute('app_membre_show', ['id' => $bibliotheque->getMembre()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bibliotheque/new.html.twig', [
            'bibliotheque' => $bibliotheque,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_bibliotheque_show", methods={"GET"})
     */
    public function show(Bibliotheque $bibliotheque): Response
    {
        $hasAccess = $this->isGranted('ROLE_ADMIN') ||
            ($this->getUser() != null && $this->getUser() == $bibliotheque->getMembre()->getUser());
        if (!$hasAccess) {
            throw $this->createAccessDeniedException("You cannot acces another member's bibliotheque!");
        }

        if (!$bibliotheque) {
            throw $this->createNotFoundException('Bibliothèque non trouvée');
        }
        return $this->render('bibliotheque/show.html.twig', [
            'bibliotheque' => $bibliotheque,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_bibliotheque_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Bibliotheque $bibliotheque, BibliothequeRepository $bibliothequeRepository): Response
    {
        $hasAccess = $this->isGranted('ROLE_ADMIN') ||
            ($this->getUser() != null && $this->getUser() == $bibliotheque->getMembre()->getUser());
        if (!$hasAccess) {
            throw $this->createAccessDeniedException("You cannot edit another member's bibliotheque!");
        }

        $form = $this->createForm(BibliothequeType::class, $bibliotheque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bibliothequeRepository->add($bibliotheque, true);

            return $this->redirectToRoute('app_membre_show', ['id' => $bibliotheque->getMembre()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bibliotheque/edit.html.twig', [
            'bibliotheque' => $bibliotheque,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_bibliotheque_delete", methods={"POST"})
     */
    public function delete(Request $request, Bibliotheque $bibliotheque, BibliothequeRepository $bibliothequeRepository): Response
    {
        $hasAccess = $this->isGranted('ROLE_ADMIN') ||
            ($this->getUser() != null && $this->getUser() == $bibliotheque->getMembre()->getUser());
        if (!$hasAccess) {
            throw $this->createAccessDeniedException("You cannot delete another member's bibliotheque!");
        }

        if ($this->isCsrfTokenValid('delete' . $bibliotheque->getId(), $request->request->get('_token'))) {
            $bibliothequeRepository->remove($bibliotheque, true);
        }

        return $this->redirectToRoute('app_membre_show', ['id' => $bibliotheque->getMembre()->getId()], Response::HTTP_SEE_OTHER);
    }
}
