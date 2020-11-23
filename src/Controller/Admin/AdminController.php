<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_browse")
     */
    public function browse(): Response
    {
        return $this->render('admin/browse.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    
}
