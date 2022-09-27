<?php

namespace App\Controller;

use App\Entity\Bibliotheque;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BibliothequeController extends AbstractController
{
    /**
     * @Route("/bibliotheque", name="app_bibliotheque")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        return $this->render('bibliotheque/index.html.twig', [
            'list_bibliotheques' => $doctrine->getManager()->getRepository(Bibliotheque::class)->findAll(),
            'url_detail' => 'app_bibliotheque_detail',
        ]);
    }

    /**
     * @Route("/bibliotheque/{id}", name="app_bibliotheque_show", requirements={"id"="\d+"})
     * @param int $id
     */
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $bibiliotheque = $doctrine->getManager()->getRepository(Bibliotheque::class)->find($id);

        if (!$bibiliotheque) {
            throw $this->createNotFoundException('Bibliothèque non trouvée');
        }

        return $this->render('bibliotheque/show.html.twig', [
            'bibliotheque' => $bibiliotheque,
        ]);
    }
}