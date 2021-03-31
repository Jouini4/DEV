<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="panier")
     */
    public function index(): Response
    {
        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController',
        ]);
    }

/**
* @Route("/afficherPanier", name="afficherPanier")
*/
    public function afficherPanier(SessionInterface $session, ProduitRepository $produitRepository )
    {
        $panier = $session->get('panier', []);
        $panierwithData = [];
        foreach ($panier as $id => $quantite){
            $panierwithData[] = [
                'produit' => $produitRepository->find($id),
                'quantite' => $quantite
            ];
        }
        $total = 0;
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
     * @Route("/ajouterPanier{id}", name="ajouterPanier")
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
        return $this->redirectToRoute("afficherPanier");

}
    /**
     * @Route("/supprimerPanier{id}", name="supprimerPanier")
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
