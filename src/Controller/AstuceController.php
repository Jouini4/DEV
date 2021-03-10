<?php

namespace App\Controller;

use App\Entity\Astuce;
use App\Entity\s;
use App\Form\AstuceType;
use App\Repository\AstuceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonRespImageonse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use GuzzleHttp\Psr7\UploadedFile;

/**
 * @Route("/astuce")
 */
class AstuceController extends AbstractController
{
    /**
     * @Route("/", name="astuce_index", methods={"GET"})

     * @return Response
     */
    public function index(AstuceRepository $astuceRepository): Response
    {
        return $this->render('astuce/AstuceProduit.html.twig', [
            'astuces' => $astuceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="astuce_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $astuce = new Astuce();
        $form = $this->createForm(AstuceType::class, $astuce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var UploadedFile $file
             */
            $file = $form->get('image')->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('images_directory'),$fileName);
            $astuce->setImage($fileName);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($astuce);
            $entityManager->flush();

            return $this->redirectToRoute('backastuce');
        }

        return $this->render('astuce/new.html.twig', [
            'astuce' => $astuce,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="astuce_show", methods={"GET"})
     */
    public function show(Astuce $astuce): Response
    {
        return $this->render('astuce/show.html.twig', [
            'astuce' => $astuce,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="astuce_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Astuce $astuce): Response
    {
        $form = $this->createForm(AstuceType::class, $astuce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var UploadedFile $file
             */
            $file = $form->get('image')->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('images_directory'),$fileName);
            $astuce->setImage($fileName);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backastuce');
        }

        return $this->render('astuce/edit.html.twig', [
            'astuce' => $astuce,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="astuce_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Astuce $astuce): Response
    {
        if ($this->isCsrfTokenValid('delete'.$astuce->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($astuce);
            $entityManager->flush();
        }

        return $this->redirectToRoute('backastuce');
    }
}
