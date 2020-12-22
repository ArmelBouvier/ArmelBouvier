<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="browse")
     */
    public function browse(): Response
    {
        return $this->render('main/browse.html.twig');
    }

    /**
     * @Route("/profil", name="profil")
     */
    public function profil(): Response
    {
        return $this->render('main/profil.html.twig');
    }

    /**
     * @Route("/experiences", name="experiences")
     */
    public function experiences(): Response
    {
        return $this->render('main/experiences.html.twig');
    }

    /**
     * @Route("/portfolio", name="portfolio")
     */
    public function portfolio(): Response
    {
        return $this->render('main/portfolio.html.twig');
    }
}
