<?php

namespace App\Controller\Admin;

use App\Entity\Stack;
use App\Form\StackType;
use App\Repository\StackRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/stack")
 */
class StackController extends AbstractController
{
    /**
     * @Route("/", name="stack_browse", methods={"GET"})
     */
    public function browse(StackRepository $stackRepository): Response
    {
        return $this->render('admin/stack/browse.html.twig', [
            'technologies' => $stackRepository->findAll(),
        ]);
    }

    /**
     * @Route("/add", name="stack_add", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $stack = new Stack();
        $form = $this->createForm(StackType::class, $stack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['image']->getData();
            $directory = $this->getParameter('kernel.project_dir').'/public/images';
            $stack->setImage($file->getClientOriginalName());
            $file->move($directory, $file->getClientOriginalName());
            $entityManager = $this->getDoctrine()->getManager();
            $stack->setCreatedAt(new \DateTime());
            $entityManager->persist($stack);
            $entityManager->flush();

            $this->addFlash('success', 'Technologie ' . $stack->getName() . ' ajoutée');

            return $this->redirectToRoute('stack_browse');
        }

        return $this->render('admin/stack/add.html.twig', [
            'academic' => $stack,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="stack_delete", requirements={"id":"\d+"}, methods={"DELETE"})
     */
    public function delete(Stack $stack): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($stack);
        $em->flush();

        $this->addFlash('success', 'Technologie supprimée');
        return $this->redirectToRoute('stack_browse');
    }

    /**
     * @Route("/edit/{id}", name="stack_edit", requirements={"id":"\d+"})
     */
    public function edit(Stack $stack, Request $request)
    {
        $form = $this->createForm(StackType::class, $stack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Le formulaire est valide, on change la valeur du $updatedAt de $academic
            $stack->setUpdatedAt(new \DateTime());

            // On peut flusher les modifications
            // Inutile de persister car l'entity manager connait déjà cet objet
            // Inutile de récupérer le manager dans $em juste pour écrire $em->flush() ensuite
            // On peut donc tout faire en une seule ligne
            $this->getDoctrine()->getManager()->flush();

            // On peut rediriger l'utilisateur vers la liste des expériences
            $this->addFlash('success', 'Technologie modifiée');
            return $this->redirectToRoute('stack_browse');
        }

        return $this->render('admin/stack/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}