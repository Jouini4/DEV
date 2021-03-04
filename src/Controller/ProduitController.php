<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitControllerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{


    /**
     * @Route("/produit", name="produit")
     */
    public function index(): Response
    {
        return $this->render('frontend/index.html.twig', [
            'controller_name' => 'ProduitController',
        ]);
    }


    /**
     * @Route("/afficherProduit", name="afficherProduit")
     */
    public function afficherProduit()
    {
        $listProduit=$this->getDoctrine()->getRepository(Produit::class)->findAll();
        return $this->render('frontend/Produit.html.twig', [
            'controller_name' => 'ProduitController','produits'=>$listProduit
        ]);
    }


    /**
     * @Route("/afficherProduitback", name="afficherProduitback")
     */
    public function afficherProduitback()
    {
        $listProduit=$this->getDoctrine()->getRepository(Produit::class)->findAll();
        return $this->render('backend/Produit.html.twig', [
            'controller_name' => 'ProduitController','produits'=>$listProduit
        ]);
    }


    /**
     * @Route("/supprimerProduit/{id}", name="supprimerProduit")
     */
    public function supprimerProduit($id)
    {
        $produit=$this->getDoctrine()->
        getRepository(Produit::class)
            ->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($produit);
        $em->flush();
        return $this->redirectToRoute('afficherProduitback');

    }


    /**
     * @Route("/ajouterProduit", name="ajouterProduit")
     */
    public function ajouterProduit(Request $request)
    {
        $produit= new Produit();
        $form=$this->createForm(ProduitControllerType::class,$produit);
        $form-> add('ajouter',SubmitType::class,['label'=>'créer']);
        //on a créé notre formulaire et on lui a passé en argument notre objet
        $form->handleRequest($request);
        //le formulaire traite la requete reçue

        //if les données reçues sont valides alors on va faire persist
        if(($form->isSubmitted())&&($form->isValid()))
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($produit); //l'ajout dans la base
            ////persist joue le role de insert into
            $em->flush();
            return $this->redirectToRoute('afficherProduitback');
        }
        else //le cas où les données sont invalides ou ne sont pas soumis
        {
            return $this->render('produit/create.html.twig', [
                'controller_name' => 'ProduitController',
                'form'=> $form ->createView() //envoyé vers le twig une vue de notre formulaire
            ]);

        }
    }


    /**
     * @Route("/modifierProduit/{id}", name="modifierProduit")
     */
    public function modifierProduit(Request $request,$id)
    {//1ere etape : chercher l'objet à modifier
        $produit =$this->getDoctrine()
            ->getRepository(Produit::class)->find($id);
        $form = $this->createForm(ProduitControllerType::class, $produit);
        $form-> add('modifier',SubmitType::class,['label'=>'modifier']);
        //ona créé notre formulaire et on lui a passé en argument notre objet
        $form->handleRequest($request);
        //le formulaire traite la requete reçue

        //if les données reçues sont valides alors on va faire persiste
        if (($form->isSubmitted()) && ($form->isValid())) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('afficherProduitback');
        } else //le cas où les données sont invalides oun ne sont pas soumis
        {
            return $this->render('produit/create.html.twig', [
                'controller_name' => 'ProduitController',
                'form' => $form->createView() //envoyé vers le twig
            ]);

        }
    }

}
