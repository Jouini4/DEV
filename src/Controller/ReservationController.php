<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;

class ReservationController extends AbstractController
{
    /**
     * @Route("/reservation", name="reservation")
     */
    public function index(): Response
    {
        return $this->render('frontend/Reservation.html.twig', [
            'controller_name' => 'ReservationController',
        ]);
    }
    /**
     * @Route("/createreservation", name="createreservation")
     */
    public function create( Request $request)
    {
        $reservation= new Reservation();
        $form=$this->createForm(ReservationType::class,$reservation);
        $form-> add('ajouter',SubmitType::class,['label'=>'Valider Votre Reservation','attr'=>array('class'=>'btn btn-primary mt-3'),]);
        //on a créé notre formulaire et on lui a passé en argument notre objet
        $form->handleRequest($request);
        //le formulaire traite la requete reçue

        //if les données reçues sont valides alors on va faire persist
        if(($form->isSubmitted())&&($form->isValid())){

            $em=$this->getDoctrine()->getManager();
            $em->persist($reservation); //l'ajout dans la base
            ////persist joue le role de insert into
            $em->flush();
            return $this->redirectToRoute('readreservation');
        }
        else //le cas où les données sont invalides ou ne sont pas soumis
        {
            return $this->render('frontend/reservation.html.twig', [
                'controller_name' => 'ReservationController',
               'form'=> $form ->createView() //envoyé vers le twig une vue de notre formulaire
            ]);

        }
    }

    /**
     * @Route("/readreservation", name="readreservation")
     */
    public function read()
    {
        $listReservation=$this->getDoctrine()->getRepository(Reservation::class)->findAll();
        //dd($listClassroom);
        return $this->render('reservation/readfront.html.twig', [
            'controller_name' => 'ReservationController','reservation'=>$listReservation
        ]);
    }
    /**
     * @Route("/listreservation", name="listreservation")
     */
    public function readlistreservation()
    {
        $listReservation=$this->getDoctrine()->getRepository(Reservation::class)->findAll();
        //dd($listClassroom);
        return $this->render('backend/reservation.html.twig', [
            'controller_name' => 'ReservationController','reservation'=>$listReservation
        ]);
    }


    /**
     * @Route("/deletereservation/{id}", name="deletereservation")
     */
    public function delete($id)
    {
        $reservation=$this->getDoctrine()->
        getRepository(Reservation::class)
            ->find($id);
        //dd($listClassroom);
        $em=$this->getDoctrine()->getManager();
        $em->remove($reservation);
        $em->flush();
        return $this->redirectToRoute('readreservation');

    }
    /**
     * @Route("/deletereservationback/{id}", name="deletereservationback")
     */
    public function deleteback($id)
    {
        $reservation=$this->getDoctrine()->
        getRepository(Reservation::class)
            ->find($id);
        //dd($listClassroom);
        $em=$this->getDoctrine()->getManager();
        $em->remove($reservation);
        $em->flush();
        return $this->redirectToRoute('listreservation');

    }

    /**
     * @Route("/updatereservation/{id}", name="updatereservation")
     */
    public function update(Request $request,$id)
    {//1ere etape : chercher l'objet à modifier
        $reservation =$this->getDoctrine()
            ->getRepository(Reservation::class)->find($id);
        $form = $this->createForm(ReservationType::class, $reservation);
        $form-> add('modifier',SubmitType::class,['label'=>'modifier','attr'=>array('class'=>'btn btn-success mt-3')]);
        //ona créé notre formulaire et on lui a passé en argument notre objet
        $form->handleRequest($request);
        //le formulaire traite la requete reçue

        //if les données reçues sont valides alors on va faire persiste
        if (($form->isSubmitted()) && ($form->isValid())) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('readreservation');
        } else //le cas où les données sont invalides oun ne sont pas soumis
        {
            return $this->render('reservation/modifierreservation.html.twig', [
                'controller_name' => 'ReservationController',
                'form' => $form->createView() //envoyé vers le twig
            ]);

        }
    }

}
