<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/project")
 */
class ProjectController extends AbstractController
{
    /**
     * @Route("/", name="project_browse", methods={"GET"})
     */
    public function browse(ProjectRepository $projectRepository): Response
    {
        return $this->render('admin/project/browse.html.twig', [
            'projects' => $projectRepository->findAll(),
        ]);
    }

    /**
     * @Route("/add", name="project_add", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $project->setCreatedAt(new \DateTime());
            $entityManager->persist($project);
            $entityManager->flush();

            $this->addFlash('success', 'Projet ' . $project->getName() . ' ajouté');

            return $this->redirectToRoute('project_browse');
        }

        return $this->render('admin/project/add.html.twig', [
            'academic' => $project,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="project_delete", requirements={"id":"\d+"}, methods={"DELETE"})
     */
    public function delete(Project $project): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($project);
        $em->flush();

        $this->addFlash('success', 'Projet supprimé');
        return $this->redirectToRoute('project_browse');
    }

    /**
     * @Route("/edit/{id}", name="project_edit", requirements={"id":"\d+"})
     */
    public function edit(Project $project, Request $request)
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Le formulaire est valide, on change la valeur du $updatedAt de $academic
            $project->setUpdatedAt(new \DateTime());

            // On peut flusher les modifications
            // Inutile de persister car l'entity manager connait déjà cet objet
            // Inutile de récupérer le manager dans $em juste pour écrire $em->flush() ensuite
            // On peut donc tout faire en une seule ligne
            $this->getDoctrine()->getManager()->flush();

            // On peut rediriger l'utilisateur vers la liste des expériences
            $this->addFlash('success', 'Projet modifié');
            return $this->redirectToRoute('project_browse');
        }

        return $this->render('admin/project/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}