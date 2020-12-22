<?php

namespace App\Controller\Admin;

use App\Repository\AcademicRepository;
use App\Repository\ExperienceRepository;
use App\Repository\ProjectRepository;
use App\Repository\StackRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_browse")
     */
    public function browse(AcademicRepository $academic, ExperienceRepository $experiences, ProjectRepository $projects, StackRepository $stack): Response
    {
        return $this->render('admin/browse.html.twig', [
            'academic' => $academic->findAll(),
            'experiences' => $experiences->findAll(),
            'projects' => $projects->findAll(),
            'stack' => $stack->findAll(),
        ]);
    }
}
