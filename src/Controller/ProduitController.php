<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitControllerType;
use App\Repository\ProduitRepository;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Material\ColumnChart;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonRespImageonse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;




use Symfony\Component\Validator\Constraints as Assert;

class ProduitController extends Controller
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
    public function afficherProduit(Request $request)
    {
        $produits=$this->getDoctrine()->getRepository(Produit::class)->findAll();
        $produit=$this->get('knp_paginator')->paginate($produits,$request->query->getInt('page',1),9);

        return $this->render('frontend/Produit.html.twig',array ('produits' => $produit
        ));
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

           /**
             * @var UploadedFile $file
             */
           $file = $form->get('image')->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('images_directory'),$fileName);

            $produit->setImage($fileName);


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
        $form-> add('modifier',SubmitType::class,['label'=>'enregistrer']);
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
            $produit->setImage($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('afficherProduitback');
        } else //le cas où les données sont invalides oun ne sont pas soumis
        {
            return $this->render('produit/update.html.twig', [
                'controller_name' => 'ProduitController',
                'form' => $form->createView() //envoyé vers le twig
            ]);

        }
    }
    /**
     * @Route ("/back/produitstat", name="produitstat")
     */
    public function produitstat(): Response
    {
        $em=$this->getDoctrine()->getManager();
        $data=$em->getRepository(Produit::class)->huile();
        $d =array(['Categorie','Nombre Total des produits'],
            );
        foreach ($data as $res)
        {
            array_push($d,[$res['categorie'],$res['nombre de produit']]);
        }

        $chart = new ColumnChart();
        $chart->getData()->setArrayToDataTable($d);
        $chart->getOptions()->getChart()->setTitle('Nombre de produit par categorie');
        $chart->getOptions()
              ->setBars('vertical')
            ->setHeight(400)
            ->setWidth(900)
            ->setColors(['#7570b3','#d95f02','#7570b3'])
            ->getVAxis()
            ->setFormat('decimal');
        return $this->render('backend/statproduit.html.twig',[
            'chart'=>$chart
        ]);
        }
    /**
     * @Route("/rechercheP", name="rechercheP")
     */
  /*  public function rechercheParCategorie(Request $request){
        $data=$request->get('recherche');
        $listProduits=$this->getDoctrine()
            ->getRepository(Produit::class)
            ->rechercheParCategorie($data);
        return $this->render('frontend/produit.html.twig',['produits'=>$listProduits]);
    }*/


    /**
     * @Route("/afficherDescription/{id}", name="afficherDescription")
     */
   public function afficherDescription($id)
    {
        $Produit=$this->getDoctrine()->getRepository(Produit::class)->find($id);
        return $this->render('frontend/ProduitsDetails.html.twig', [
            'controller_name' => 'ProduitController','produits'=>$Produit
        ]);
    }

    /**
     * @Route("/afficherPanier", name="afficherPanier")
     *@Security("is_granted('ROLE_USER')")
     */
    public function afficherPanier(SessionInterface $session, ProduitRepository $produitRepository )
    {
        $panier = $session->get('panier', []);
        dump($panier);
        $panierwithData = [];
        foreach ($panier as $id => $quantite){
            $panierwithData[] = [
                'produit' => $produitRepository->find($id),
                'quantite' => $quantite
            ];
        }
        $total = 0;
        dump($panierwithData);
        foreach ($panierwithData as $panierd) {
            $totalPanier = $panierd['produit']->getPrix() * $panierd['quantite'];
            $total += $totalPanier;

        }

        return $this->render('frontend/Panier.html.twig',[
            'panierD' => $panierwithData,
            'total' => $total
        ]);
    }

    /**
     * @Route("/updatePanier/{idP}/{qte}", name="updatePanier")
     */
    public function updatePanier(SessionInterface $session, ProduitRepository $produitRepository,$idP,$qte)
    {
        $panier = $session->get('panier');
        dump($panier);
        $panier[$idP]=intval($qte);
        dump($panier);
        $session->set('panier', $panier);
        $panierwithData = [];
        foreach ($panier as $id => $quantite){
            if($id == $idP){
                $panierwithData[] = [
                    'produit' => $produitRepository->find($id),
                    'quantite' => $qte
                ];
            }else{
                $panierwithData[] = [
                    'produit' => $produitRepository->find($id),
                    'quantite' => $quantite
                ];
            }


        }
        $total = 0;
        foreach ($panierwithData as $panierd) {
            if($panierd['produit']->getId()==$idP)
            $panierd['quantite']=$qte;

            $totalPanier = $panierd['produit']->getPrix() * $panierd['quantite'];
            $total += $totalPanier;
        }

        return $this->render('frontend/Panier.html.twig',[
            'panierD' => $panierwithData,
            'total' => $total
        ]);
    }

    /**
     * @Route("/ajouterPanier{id}", name="ajouterPanier")
     * *@Security("is_granted('ROLE_USER')")
     */
    public function ajouterPanier($id, SessionInterface $session){
        $panier = $session->get('panier',[]);
        if(!empty($panier[$id])){
            $panier[$id]++;
        }
        else{
            $panier[$id] = 1;
        }
        $session->set('panier', $panier);
        return $this->redirectToRoute("afficherProduit");

    }
    /**
     * @Route("/supprimerPanier{id}", name="supprimerPanier")
     * *@Security("is_granted('ROLE_USER')")
     */
    public function supprimerPanier($id, SessionInterface $session){
        $panier = $session->get('panier',[]);
        if(!empty($panier[$id])){
            unset($panier[$id]);
        }
        $session->set('panier', $panier);
        return $this->redirectToRoute("afficherPanier");
    }



}
