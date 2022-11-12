<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Entity\Membre;
use App\Entity\User;
use App\Entity\Vitrine;
use App\Form\VitrineType;
use App\Repository\VitrineRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/vitrine")
 */
class VitrineController extends AbstractController
{
    /**
     * @Route("/", name="app_vitrine_index", methods={"GET"})
     */
    public function index(VitrineRepository $vitrineRepository): Response
    {
        // Par user
        $vitrines_privees = array();
        /** @var \App\Entity\User */
        $user = $this->getUser();
        if ($user) {
            $membre = $user->getMembre();
            $vitrines_privees = $vitrineRepository->findBy(['published' => false, 'createur' => $membre]);
        }

        // Admin 
        if ($this->isGranted('ROLE_ADMIN')) {
            $vitrines_privees = $vitrineRepository->findBy(['published' => false]);
        }

        $vitrines_publiques = $vitrineRepository->findBy(['published' => true]);
        return $this->render('vitrine/index.html.twig', [
            'vitrines_publiques' => $vitrines_publiques,
            'vitrines_privees' => $vitrines_privees,
        ]);
    }

    /**
     * @Route("/new/{id}", name="app_vitrine_new", methods={"GET", "POST"})
     */
    public function new(Request $request, VitrineRepository $vitrineRepository, Membre $membre): Response
    {
        $hasAccess = $this->isGranted('ROLE_ADMIN') ||
            ($this->getUser() != null && $this->getUser() == $membre->getUser());
        if (!$hasAccess) {
            throw $this->createAccessDeniedException("You cannot create another member's vitrine!");
        }

        $vitrine = new Vitrine();
        $vitrine->setCreateur($membre);
        $form = $this->createForm(VitrineType::class, $vitrine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vitrineRepository->add($vitrine, true);

            return $this->redirectToRoute('app_vitrine_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vitrine/new.html.twig', [
            'vitrine' => $vitrine,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_vitrine_show", methods={"GET"})
     */
    public function show(Vitrine $vitrine): Response
    {
        $hasAccess = false;
        if ($this->isGranted('ROLE_ADMIN') || $vitrine->isPublished()) {
            $hasAccess = true;
        } else {
            /** @var \App\Entity\User */
            $user = $this->getUser();
            if ($user) {
                $membre = $user->getMembre();

                if ($membre &&  ($membre == $vitrine->getCreateur())) {
                    $hasAccess = true;
                }
            }
        }
        if (!$hasAccess) {
            throw $this->createAccessDeniedException("You cannot access the requested resource!");
        }
        return $this->render('vitrine/show.html.twig', [
            'vitrine' => $vitrine,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_vitrine_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Vitrine $vitrine, VitrineRepository $vitrineRepository): Response
    {
        $hasAccess = $this->isGranted('ROLE_ADMIN') ||
            ($this->getUser() != null && $this->getUser() == $vitrine->getCreateur()->getUser());
        if (!$hasAccess) {
            throw $this->createAccessDeniedException("You cannot edit another member's bibliotheque!");
        }

        $form = $this->createForm(VitrineType::class, $vitrine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vitrineRepository->add($vitrine, true);

            return $this->redirectToRoute('app_vitrine_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vitrine/edit.html.twig', [
            'vitrine' => $vitrine,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_vitrine_delete", methods={"POST"})
     */
    public function delete(Request $request, Vitrine $vitrine, VitrineRepository $vitrineRepository): Response
    {
        $hasAccess = $this->isGranted('ROLE_ADMIN') ||
            ($this->getUser() != null && $this->getUser() == $vitrine->getCreateur()->getUser());
        if (!$hasAccess) {
            throw $this->createAccessDeniedException("You cannot delete another member's bibliotheque!");
        }

        if ($this->isCsrfTokenValid('delete' . $vitrine->getId(), $request->request->get('_token'))) {
            $vitrineRepository->remove($vitrine, true);
        }

        return $this->redirectToRoute('app_vitrine_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/livre/{id_livre}", name="app_vitrine_show_livre", methods={"GET"})
     * @ParamConverter("livre", options={"id" = "id_livre"})
     */
    public function showLivre(Request $request, Vitrine $vitrine, Livre $livre): Response
    {
        if (!$vitrine->getLivres()->contains($livre)) {
            throw $this->createNotFoundException("Couldn't find such a [objet] in this [galerie]!");
        }

        $hasAccess = false;
        if ($this->isGranted('ROLE_ADMIN') || $vitrine->isPublished()) {
            $hasAccess = true;
        } else {
            /** @var \App\Entity\User */
            $user = $this->getUser();
            if ($user) {
                $member = $user->getMembre();
                if ($member &&  ($member == $vitrine->getCreateur())) {
                    $hasAccess = true;
                }
            }
        }
        if (!$hasAccess) {
            throw $this->createAccessDeniedException("You cannot access the requested ressource!");
        }

        return $this->render('vitrine/show_livre.html.twig', [
            'vitrine' => $vitrine,
            'livre' => $livre,
        ]);
    }

    /**
     * @Route("/{id_vitrine}/favorite/{id_livre}", name="app_vitrine_toogle_favorite", methods={"POST"})
     * @ParamConverter("livre", options={"id" = "id_livre"})
     * @ParamConverter("vitrine", options={"id" = "id_vitrine"})
     */
    public function toogleFavorite(Request $request, Livre $livre, Vitrine $vitrine): Response
    {
        $urgents = $request->getSession()->get('urgents');
        if (!is_array($urgents)) {
            $urgents = array();
        }
        if (in_array($livre->getId(), $urgents)) {
            $urgents = array_diff($urgents, [$livre->getId()]);
        } else {
            $urgents[] = $livre->getId();
        }

        $request->getSession()->set('urgents', $urgents);

        return $this->redirectToRoute('app_vitrine_show_livre', ['id_livre' => $livre->getId(), 'id' => $vitrine->getId()], Response::HTTP_SEE_OTHER);
    }
}