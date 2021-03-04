<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\File\File;



use Symfony\Component\Validator\Constraints as Assert;

class EvenementController extends AbstractController
{
    /**
     * @Route("/evenement", name="evenement")
     */
    public function index(): Response
    {
        return $this->render('evenement/index.html.twig', [
            'controller_name' => 'EvenementController',
        ]);
    }
    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request)
    {
        $evenement= new Evenement();
        $form=$this->createForm(EvenementType::class,$evenement);
        $form-> add('ajouter',SubmitType::class,['label'=>'créer','attr'=>array('class'=>'btn btn-primary mt-3'),]);
        //on a créé notre formulaire et on lui a passé en argument notre objet
        $form->handleRequest($request);
        //le formulaire traite la requete reçue

        //if les données reçues sont valides alors on va faire persist
        if(($form->isSubmitted())&&($form->isValid())){
            /**
             * @var UploadedFile $file
             */
            $file = $form->get('image')->getData();
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $file->move($this->getParameter('images_directory'),$fileName);
        $evenement->setImage($fileName);
        $em=$this->getDoctrine()->getManager();
            $em->persist($evenement); //l'ajout dans la base
            ////persist joue le role de insert into
            $em->flush();
            return $this->redirectToRoute('read');
        }
        else //le cas où les données sont invalides ou ne sont pas soumis
        {
            return $this->render('backend/evenement.html.twig', [
                'controller_name' => 'EvenementController',
                'form'=> $form ->createView() //envoyé vers le twig une vue de notre formulaire
            ]);

        }
    }
    /**
     * @Route("/read", name="read")
     */
    public function read()
    {
        $listEvenement=$this->getDoctrine()->getRepository(Evenement::class)->findAll();
        //dd($listClassroom);
        return $this->render('evenement/read.html.twig', [
            'controller_name' => 'EvenementController','evenement'=>$listEvenement
        ]);
    }
    /**
     * @Route("/readeventfront", name="readfront")
     */
    public function readfront()
    {
        $listEvenement=$this->getDoctrine()->getRepository(Evenement::class)->findAll();
        //dd($listClassroom);
        return $this->render('frontend/Evenement.html.twig', [
            'controller_name' => 'EvenementController','evenements'=>$listEvenement
        ]);
    }
    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete($id)
    {
        $evenemnt=$this->getDoctrine()->
        getRepository(Evenement::class)
            ->find($id);
        //dd($listClassroom);
        $em=$this->getDoctrine()->getManager();
        $em->remove($evenemnt);
        $em->flush();
        return $this->redirectToRoute('read');

    }
    /**
     * @Route("/update/{id}", name="update")
     */
    public function update(Request $request,$id)
    {//1ere etape : chercher l'objet à modifier
        $evenement =$this->getDoctrine()
            ->getRepository(Evenement::class)->find($id);
        $form = $this->createForm(EvenementType::class, $evenement);
        $form-> add('modifier',SubmitType::class,['label'=>'modifier']);
        //ona créé notre formulaire et on lui a passé en argument notre objet
        $form->handleRequest($request);
        //le formulaire traite la requete reçue

        //if les données reçues sont valides alors on va faire persiste
        if (($form->isSubmitted()) && ($form->isValid())) {
            /**
             * @var UploadedFile $file
             */
            $file = $form->get('image')->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('images_directory'),$fileName);
            $evenement->setImage($fileName);
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('read');
        } else //le cas où les données sont invalides oun ne sont pas soumis
        {
            return $this->render('backend/evenement.html.twig', [
                'controller_name' => 'EvenementController',
                'form' => $form->createView() //envoyé vers le twig
            ]);

        }
    }
}
