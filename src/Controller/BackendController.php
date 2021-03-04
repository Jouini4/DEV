<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\Livraison;
use App\Form\CommandeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        $em=$this->getDoctrine()->getManager();
        $commandes = $em->getRepository(Commande::class)->findAll();
        return $this->render('backend/commande.html.twig', [
            'commandes'=>$commandes

        ]);
    }
    /**
     * @Route("/back/modifiercommande/{REF}", name="backmodifiercommande")
     */
    public function Modifiercommande(Request $request,$REF): Response
    {
        // dump($request);
        $form = $this->createForm(CommandeType::class);
        $form= $form->handleRequest($request);
        $em=$this->getDoctrine()->getManager();
        $commande=$em->getRepository(Commande::class)->find($REF);


        $client = $em->getRepository(Client::class)->find($commande->getClient()->getId());
        if ($form->isSubmitted())
        {
            dump($request);
            $commande->setAdresse($request->request->get('commande')['adresse']);
            $commande->setDescriptionAdresse($request->request->get('commande')['description_adresse']);
            $commande->setGouvernorat($request->request->get('commande')['gouvernorat']);
            $commande->setCodePostal($request->request->get('commande')['code_postal']);
            $commande->setNumeroTelephone((int)$request->request->get('commande')['numero_telephone']);


            $em->flush();
            return $this->redirectToRoute('backcommande');

        }
        return $this->render('backend/modifiercommande.html.twig', [
            'form'=>$form->createView(),
            'commande'=>$commande

        ]);
    }
    /**
     * @Route("/back/supprimercommande/{REF}", name="backsupprimercommande")
     */
    public function Supprimercommande($REF): Response
    {
        $em = $this->getDoctrine()->getManager();
        $commande=$em->getRepository(Commande::class)->find($REF);
        $em->remove($commande);
        $em->flush();

        return $this->redirectToRoute('backcommande');
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
        $em=$this->getDoctrine()->getManager();
        $livraisons = $em->getRepository(Livraison::class)->findAll();
        //dump($livraisons[0]->getCommande()->getClient()->getNom());

        return $this->render('backend/livraison.html.twig', [
            'livraisons'=>$livraisons
        ]);
    }


    /**
     * @Route("/back/supprimerlivraison/{Numero}", name="backsupprimerlivraison")
     */
    public function Supprimerlivraison($Numero): Response
    {
        $em = $this->getDoctrine()->getManager();
        $livraison=$em->getRepository(Livraison::class)->find($Numero);
        $em->remove($livraison);
        $em->flush();

        return $this->redirectToRoute('backlivraison');
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
     * @Route("/back/stock", name="backstock")
     */
    public function stock(): Response
    {
        return $this->render('backend/stock.html.twig', [

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
