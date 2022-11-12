<?php

namespace App\Controller;

use App\Entity\Membre;
use App\Repository\MembreRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/membre")
 */
class MembreController extends AbstractController
{
    /**
     * @Route("/", name="app_membre_index", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(MembreRepository $membreRepository): Response
    {
        return $this->render('membre/index.html.twig', [
            'membres' => $membreRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_membre_show", methods={"GET"})
     */
    public function show(Membre $membre): Response
    {
        $hasAccess = $this->isGranted('ROLE_ADMIN') ||
            ($this->getUser() != null && $this->getUser() == $membre->getUser());
        if (!$hasAccess) {
            throw $this->createAccessDeniedException("You cannot view another member's profile!");
        }
        return $this->render('membre/show.html.twig', [
            'membre' => $membre,
        ]);
    }
}