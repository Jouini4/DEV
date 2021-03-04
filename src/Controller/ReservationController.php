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
     * @Route("/createresrvation", name="createreservation")
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
            return $this->redirectToRoute('readfront');
        }
        else //le cas où les données sont invalides ou ne sont pas soumis
        {
            return $this->render('frontend/reservation.html.twig', [
                'controller_name' => 'ReservationController',
               'form'=> $form ->createView() //envoyé vers le twig une vue de notre formulaire
            ]);

        }
    }
}
