<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackendController extends AbstractController
{
    /**
     * @Route("/back", name="backindex")
     */
    public function index(): Response
    {
        return $this->render('backend/index.html.twig', [

        ]);
    }
    /**
     * @Route("/back/promo", name="backpromo")
     */
    public function promo(): Response
    {
        return $this->render('backend/promo.html.twig', [

        ]);
    }
    /**
     * @Route("/back/reclamation", name="backreclamation")
     */
    public function reclamation(): Response
    {
        return $this->render('backend/reclamation.html.twig', [

        ]);
    }

    /**
     * @Route("/back/utilisateur", name="backutilisateur")
     */
    public function utilisateur(): Response
    {
        return $this->render('backend/utilisateur.html.twig', [

        ]);
    }
    /**
     * @Route("/back/admin", name="backadmin")
     */
    public function admin(): Response
    {
        return $this->render('backend/admin.html.twig', [

        ]);
    }
    /**
     * @Route("/back/commande", name="backcommande")
     */
    public function commande(): Response
    {
        return $this->render('backend/commande.html.twig', [

        ]);
    }
    /**
     * @Route("/back/evenement", name="backevenement")
     */
    public function evenement(): Response
    {
        return $this->render('backend/evenement.html.twig', [

        ]);
    }

    /**
     * @Route("/back/livraison", name="backlivraison")
     */
    public function livraison(): Response
    {
        return $this->render('backend/livraison.html.twig', [

        ]);
    }

    /**
     * @Route("/back/login", name="backlogin")
     */
    public function login(): Response
    {
        return $this->render('backend/login.html.twig', [

        ]);
    }

    /**
     * @Route("/back/produit", name="backproduit")
     */
    public function produit(): Response
    {
        return $this->render('backend/produit.html.twig', [

        ]);
    }

    /**
     * @Route("/back/listreservation", name="listreservation")
     */
    public function stock(): Response
    {
        return $this->render('backend/reservation.html.twig', [

        ]);
    }

    /**
     * @Route("/back/video", name="backvideo")
     */
    public function video(): Response
    {
        return $this->render('backend/video.html.twig', [

        ]);
    }

    /**
     * @Route("/back/astuce", name="backastuce")
     */
    public function astuce(): Response
    {
        return $this->render('backend/astuce.html.twig', [

        ]);
    }

}
