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
    public function browse(): Response
    {
        return $this->render('movie/browse.html.twig', [
            'movies' => $movieRepository->findAll(),
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

            $this->addFlash('success', 'Formation '. $academic->getDiplomaTitle() . ' ajoutée');

            return $this->redirectToRoute('academic_browse');
        }

        return $this->render('admin/academic/add.html.twig', [
            'academic' => $academic,
            'form' => $form->createView(),
        ]);
    }
}
