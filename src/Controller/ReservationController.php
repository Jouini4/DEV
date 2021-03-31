<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Evenement;
use App\Entity\Reservation;
use Knp\Component\Pager\PaginatorInterface;
use ProxyManager\Exception\ExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ReservationController extends Controller
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
     * @Route("/reserverEvent/{id}", name="reserverEvent")
     *@Security("is_granted('ROLE_USER')")
     */
    public function reserverEvent(Request $req ,$id)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $evenement = $this->getDoctrine()->getRepository(Evenement::class)->find($id);
        $reservation = new Reservation();
        $reservation->setUser($user);
        if($req->isMethod("post")) {
            $reservation->setIdEvent($evenement);
            $nbredeticketDemandé=(int)($req->get('nbrplace'));
            $reservation->setApprouve(0);


            if( $nbredeticketDemandé <= $evenement->getNbrPlace()){
                $reservation->setNbrPlace($nbredeticketDemandé);


                $evenement->setNbrPlace(($evenement->getNbrPlace())-(int)($req->get('nbrplace')));
            }
            else {
                return $this->redirectToRoute('reserverEvent', array('id'=>$id));
            }
            try{
                $em->persist($reservation);
                $em->flush();
                return $this->redirectToRoute('readreservation');

            }catch(ExceptionInterface $e){
            }


        }

        return $this->render('evenement/evenement1.html.twig',array('evenement'=>$evenement));
    }

    /**
     * @Route("/listreservation/{id}", name="afficherReservation")
     */
    public function listReservationByEvent($id,Request $request,PaginatorInterface $paginator){
        $event=$this->getDoctrine()->getRepository(Evenement::class)->find($id);
        $AlllistReservation=$this->getDoctrine()->getRepository(Reservation::class)->findBy(array('id_Event'=>$event));
        // Paginate the results of the query
        $listReservation= $paginator->paginate(
        // Doctrine Query, not results
            $AlllistReservation,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            2
        );
        return $this->render('reservation/listReservation.html.twig',[
            'controller_name' => 'ReservationController','reservations'=>$listReservation]);

    }
    /**
     * @Route("/listreser", name="listReservation")
     */
    public function listReservation(Request $request,PaginatorInterface $paginator){
        $AlllistReservation=$this->getDoctrine()->getRepository(Reservation::class)->findAll();
        // Paginate the results of the query
        $listReservation= $paginator->paginate(

        // Doctrine Query, not results
            $AlllistReservation,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            3
        );
        return $this->render('reservation/listReser.html.twig',[
            'controller_name' => 'ReservationController', 'reservations'=>$listReservation]

    );

    }


    /**
     * @param $id
     * @Route("/approuverReservation/{id}",name="approuverReservation")
     */
    public function approuverReservation($id,\Swift_Mailer $mailer)
    {   $user = $this->get('security.token_storage')->getToken()->getUser();
        $em= $this->getDoctrine()->getManager();
        $reservation=$em->getRepository( Reservation::class)->find($id);
        $reservation->setApprouve(1);
        $message = (new \Swift_Message('Validation Réservation'))
            ->setFrom('jouini.mohamednourelhak@esprit.tn')
            ->setTo($reservation->getUser()->getEmail())
            ->setBody(
                $this->renderView(
                    'reservation/confirmation_mail.html.twig'
                ),
                'text/html'
            );
        $em->merge($reservation);
        $em->flush();
        $mailer->send($message);

        return $this->redirectToRoute('listReservation',array('id'=>$id));

    }
    /**
     * @Route("/readreservation", name="readreservation")
     * *@Security("is_granted('ROLE_USER')")
     */
    public function read()
    {
        $listReservation=$this->getDoctrine()->getRepository(Reservation::class)->findAll();
        //dd($listClassroom);
        return $this->render('reservation/readfront.html.twig', [
            'controller_name' => 'ReservationController','reservation'=>$listReservation,

        ]);
    }



}
