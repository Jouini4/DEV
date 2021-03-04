<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontendController extends AbstractController
{
    /**
     * @Route("/", name="frontindex")
     */
    public function index(): Response
    {
        return $this->render('frontend/index.html.twig', [

        ]);
    }

    /**
     * @Route("/produit", name="produit")
     */
    public function Produit(): Response
    {
        return $this->render('frontend/Produit.html.twig', [

        ]);
    }

    /**
     * @Route("/reservation", name="reservation")
     */
    public function Reservation(): Response
    {
        return $this->render('frontend/Reservation.html.twig', [

        ]);
    }
    /**
     * @Route("/astuceproduit", name="astuceproduit")
     */
    public function AstuceP(): Response
    {
        return $this->render('frontend/AstuceProduit.html.twig', [

        ]);
    }
    /**
     * @Route("/blog", name="blog")
     */
    public function Blog(): Response
    {
        return $this->render('frontend/Blog.html.twig', [

        ]);
    }

    /**
     * @Route("/connexion", name="connexion")
     */
    public function Connexion(): Response
    {
        return $this->render('frontend/Connexion.html.twig', [

        ]);
    }
    /**
     * @Route("/readeventfront", name="evenement")
     */
    public function Evenement(): Response
    {
        return $this->render('frontend/Evenement.html.twig', [

        ]);
    }
    /**
     * @Route("/inscription", name="inscription")
     */
    public function Inscription(): Response
    {
        return $this->render('frontend/Inscription.html.twig', [

        ]);
    }
    /**
     * @Route("/panier", name="panier")
     */
    public function Panier(): Response
    {
        return $this->render('frontend/Panier.html.twig', [

        ]);
    }
    /**
     * @Route("/produitdetails", name="produitdetails")
     */
    public function ProduitD(): Response
    {
        return $this->render('frontend/ProduitsDetails.html.twig', [

        ]);
    }
    /**
     * @Route("/contact", name="contact")
     */
    public function contact(): Response
    {
        return $this->render('frontend/Contact.html.twig', [

        ]);
    }
    /**
     * @Route("/reclamation", name="reclamation")
     */
    public function Reclamation(): Response
    {
        return $this->render('frontend/Reclamation.html.twig', [

        ]);
    }
}
