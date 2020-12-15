<?php

namespace App\Controller\Admin;

use App\Entity\Experience;
use App\Form\ExperienceType;
use App\Repository\ExperienceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/experience")
 */
class ExperienceController extends AbstractController
{
    /**
     * @Route("/", name="experience_browse", methods={"GET"})
     */
    public function browse(ExperienceRepository $experienceRepository): Response
    {
        return $this->render('admin/experience/browse.html.twig', [
            'experiences' => $experienceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/add", name="experience_add", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $experience = new Experience();
        $form = $this->createForm(ExperienceType::class, $experience);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $experience->setCreatedAt(new \DateTime());
            $entityManager->persist($experience);
            $entityManager->flush();

            $this->addFlash('success', 'Poste ' . $experience->getName() . ' ajouté');

            return $this->redirectToRoute('experience_browse');
        }

        return $this->render('admin/experience/add.html.twig', [
            'academic' => $experience,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="experience_delete", requirements={"id":"\d+"}, methods={"DELETE"})
     */
    public function delete(Experience $experience): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($experience);
        $em->flush();

        $this->addFlash('success', 'Expérience supprimée');
        return $this->redirectToRoute('experience_browse');
    }

    /**
     * @Route("/edit/{id}", name="experience_edit", requirements={"id":"\d+"})
     */
    public function edit(Experience $experience, Request $request)
    {
        $form = $this->createForm(ExperienceType::class, $experience);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Le formulaire est valide, on change la valeur du $updatedAt de $academic
            $experience->setUpdatedAt(new \DateTime());

            // On peut flusher les modifications
            // Inutile de persister car l'entity manager connait déjà cet objet
            // Inutile de récupérer le manager dans $em juste pour écrire $em->flush() ensuite
            // On peut donc tout faire en une seule ligne
            $this->getDoctrine()->getManager()->flush();

            // On peut rediriger l'utilisateur vers la liste des expériences
            $this->addFlash('success', 'Expérience modifiée');
            return $this->redirectToRoute('experience_browse');
        }

        return $this->render('admin/experience/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
