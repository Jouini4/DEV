<?php

namespace App\Controller;

use App\Entity\Typereclamation;
use App\Form\TypereclamationType;
use App\Repository\TypereclamationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/back/typereclamation")
 */
class TypereclamationController extends AbstractController
{
    /**
     * @Route("/", name="typereclamation_index", methods={"GET"})
     */
    public function index(TypereclamationRepository $typereclamationRepository): Response
    {
        return $this->render('typereclamation/index.html.twig', [
            'typereclamations' => $typereclamationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="typereclamation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $typereclamation = new Typereclamation();
        $form = $this->createForm(TypereclamationType::class, $typereclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($typereclamation);
            $entityManager->flush();

            return $this->redirectToRoute('typereclamation_index');
        }

        return $this->render('typereclamation/new.html.twig', [
            'typereclamation' => $typereclamation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="typereclamation_show", methods={"GET"})
     */
    public function show(Typereclamation $typereclamation): Response
    {
        return $this->render('typereclamation/show.html.twig', [
            'typereclamation' => $typereclamation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="typereclamation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Typereclamation $typereclamation): Response
    {
        $form = $this->createForm(TypereclamationType::class, $typereclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('typereclamation_index');
        }

        return $this->render('typereclamation/edit.html.twig', [
            'typereclamation' => $typereclamation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="typereclamation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Typereclamation $typereclamation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typereclamation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($typereclamation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('typereclamation_index');
    }
}
