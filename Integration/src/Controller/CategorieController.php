<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieControllerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="categorie")
     */
    public function index(): Response
    {
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }

    /**
     * @Route("/afficherCategoriefront", name="afficherCategoriefront")
     */
    public function afficherCategoriefront()
    {
        $listcategorie=$this->getDoctrine()->getRepository(Categorie::class)->findAll();
        return $this->render('categorie/readf.html.twig', [
            'controller_name' => 'CategorieController','categories'=>$listcategorie
        ]);
    }


    /**
     * @Route("/afficherCategorie", name="afficherCategorie")
     */
    public function afficherCategorie()
    {
        $listcategorie=$this->getDoctrine()->getRepository(Categorie::class)->findAll();
        return $this->render('categorie/read.html.twig', [
            'controller_name' => 'CategorieController','categories'=>$listcategorie
        ]);
    }



    /**
     * @Route("/supprimerCategorie/{id}", name="supprimerCategorie")
     */
    public function supprimerCategorie($id)
    {
        $categorie=$this->getDoctrine()->
        getRepository(Categorie::class)->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($categorie);
        $em->flush();
        return $this->redirectToRoute('afficherCategorie');

    }


    /**
     * @Route("/ajouterCategorie", name="ajouterCategorie")
     */
    public function ajouterCategorie(Request $request)
    {
        $categorie= new Categorie();
        $form=$this->createForm(CategorieControllerType::class,$categorie);
        $form-> add('ajouter',SubmitType::class,['label'=>'créer']);
        //on a créé notre formulaire et on lui a passé en argument notre objet
        $form->handleRequest($request);
        //le formulaire traite la requete reçue

        //if les données reçues sont valides alors on va faire persist
        if(($form->isSubmitted())&&($form->isValid()))
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($categorie); //l'ajout dans la base
            ////persist joue le role de insert into
            $em->flush();
            return $this->redirectToRoute('afficherCategorie');

        }
        else //le cas où les données sont invalides ou ne sont pas soumis
        {

            return $this->render('categorie/create.html.twig', [
                'controller_name' => 'CategorieController',
                'form'=> $form ->createView() //envoyé vers le twig une vue de notre formulaire
            ]);

        }
    }


    /**
     * @Route("/modifierCategorie/{id}", name="modifierCategorie")
     */
    public function modifierCategorie(Request $request,$id)
    {//1ere etape : chercher l'objet à modifier
        $categorie =$this->getDoctrine()
            ->getRepository(Categorie::class)->find($id);
        $form = $this->createForm(CategorieControllerType::class, $categorie);
        $form-> add('modifier',SubmitType::class,['label'=>'modifier']);
        //ona créé notre formulaire et on lui a passé en argument notre objet
        $form->handleRequest($request);
        //le formulaire traite la requete reçue

        //if les données reçues sont valides alors on va faire persiste
        if (($form->isSubmitted()) && ($form->isValid())) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('afficherCategorie');
        } else //le cas où les données sont invalides oun ne sont pas soumis
        {
            return $this->render('categorie/update.html.twig', [
                'controller_name' => 'CategorieController',
                'form'=> $form ->createView() //envoyé vers le twig une vue de notre formulaire
            ]);

        }
    }
}
