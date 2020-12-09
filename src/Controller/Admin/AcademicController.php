<?php

namespace App\Controller\Admin;

use App\Entity\Academic;
use App\Form\AcademicType;
use App\Repository\AcademicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/academic")
 */
class AcademicController extends AbstractController
{
    /**
     * @Route("/", name="academic_browse", methods={"GET"})
     */
    public function browse(AcademicRepository $academicRepository): Response
    {
        return $this->render('admin/academic/browse.html.twig', [
            'formations' => $academicRepository->findAll(),
        ]);
    }

    /**
     * @Route("/add", name="academic_add", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $academic = new Academic();
        $form = $this->createForm(AcademicType::class, $academic);
        $form->handleRequest($request);
        // dd($form);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $academic->setCreatedAt(new \DateTime());
            $entityManager->persist($academic);
            $entityManager->flush();

            $this->addFlash('success', 'Formation ' . $academic->getDiplomaTitle() . ' ajoutée');

            return $this->redirectToRoute('academic_browse');
        }

        return $this->render('admin/academic/add.html.twig', [
            'academic' => $academic,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="academic_delete", requirements={"id":"\d+"}, methods={"DELETE"})
     */
    public function delete(Academic $academic): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($academic);
        $em->flush();

        $this->addFlash('success', 'Formation supprimée');
        return $this->redirectToRoute('academic_browse');
    }

    /**
     * @Route("/edit/{id}", name="academic_edit", requirements={"id":"\d+"})
     */
    public function edit(Academic $academic, Request $request)
    {
        $form = $this->createForm(AcademicType::class, $academic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Le formulaire est valide, on change la valeur du $updatedAt de $academic
            $academic->setUpdatedAt(new \DateTime());

            // On peut flusher les modifications
            // Inutile de persister car l'entity manager connait déjà cet objet
            // Inutile de récupérer le manager dans $em juste pour écrire $em->flush() ensuite
            // On peut donc tout faire en une seule ligne
            $this->getDoctrine()->getManager()->flush();

            // On peut rediriger l'utilisateur vers la liste des formations
            $this->addFlash('success', 'Formation modifiée');
            return $this->redirectToRoute('academic_browse');
        }

        return $this->render('admin/academic/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
