<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Commande;
use App\Form\CommandeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/Ajoutercommande", name="Addcommande")
     */
    public function AddCommande(Request $request): Response
    {
       // dump($request);
        $form = $this->createForm(CommandeType::class);
        $form= $form->handleRequest($request);
        $commande = new Commande();
        // $Panier = $em->getRepository(Panier::class)->find(1)
        // boucle : somme
        $total_panier = 750;
        $em=$this->getDoctrine()->getManager();
        $client = $em->getRepository(Client::class)->find(1);
        if ($form->isSubmitted())
        {
            dump($request);
            $commande->setAdresse($request->request->get('commande')['adresse']);
            $commande->setDescriptionAdresse($request->request->get('commande')['description_adresse']);
            $commande->setGouvernorat($request->request->get('commande')['gouvernorat']);
            $commande->setCodePostal($request->request->get('commande')['code_postal']);
            $commande->setNumeroTelephone((int)$request->request->get('commande')['numero_telephone']);
            $commande->setPrixTotal($total_panier);

            $commande->setClient($client);

            $em->persist($commande);
            $em->flush();
            return $this->redirectToRoute('livraison');

        }



        return $this->render('frontend/AjouterCommande.html.twig', ['client'=>$client,'total'=>$total_panier,
            'form' => $form->createView(),

        ]);


    }
    /**
     * @Route("/Modifiercommande", name="Modifycommande")
     */
    public function ModifyCommande(): Response
    {
        return $this->render('frontend/ModifierCommande.html.twig', [

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
     * @Route("/evenement", name="evenement")
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
    public function reservation(): Response
    {
        return $this->render('frontend/Reclamation.html.twig', [

        ]);
    }
}
