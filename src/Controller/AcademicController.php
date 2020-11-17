<?php

namespace App\Controller;

use App\Entity\Academic;
use App\Form\AcademicType;
use App\Repository\AcademicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/academic")
 */
class AcademicController extends AbstractController
{
    /**
     * @Route("/", name="academic_index", methods={"GET"})
     */
    public function index(AcademicRepository $academicRepository): Response
    {
        return $this->render('academic/index.html.twig', [
            'academics' => $academicRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="academic_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $academic = new Academic();
        $form = $this->createForm(AcademicType::class, $academic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($academic);
            $entityManager->flush();

            return $this->redirectToRoute('academic_index');
        }

        return $this->render('academic/new.html.twig', [
            'academic' => $academic,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="academic_show", methods={"GET"})
     */
    public function show(Academic $academic): Response
    {
        return $this->render('academic/show.html.twig', [
            'academic' => $academic,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="academic_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Academic $academic): Response
    {
        $form = $this->createForm(AcademicType::class, $academic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('academic_index');
        }

        return $this->render('academic/edit.html.twig', [
            'academic' => $academic,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="academic_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Academic $academic): Response
    {
        if ($this->isCsrfTokenValid('delete'.$academic->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($academic);
            $entityManager->flush();
        }

        return $this->redirectToRoute('academic_index');
    }
}
