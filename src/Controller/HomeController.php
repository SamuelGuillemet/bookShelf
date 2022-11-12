<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(): Response
    {
        /** @var \App\Entity\User */
        $user = $this->getUser();
        if ($user != null) {
            $membre = $user->getMembre();
            if ($membre != null) {
                return $this->redirectToRoute('app_membre_show', ['id' => $membre->getId()]);
            }
        }
        return $this->render('home/index.html.twig');
    }
}