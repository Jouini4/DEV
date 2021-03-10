<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\Livraison;
use App\Entity\Produit;
use App\Form\CommandeType;
use App\Form\LivraisonType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
    public function AddCommande(Request $request,ValidatorInterface $validator): Response
    {

        $errors = null;
       // dump($request);
        $form = $this->createForm(CommandeType::class);
        $form= $form->handleRequest($request);
        $commande = new Commande();
        // $Panier = $em->getRepository(Panier::class)->find(1)
        // boucle : somme
        $total_panier = 750;
        $em=$this->getDoctrine()->getManager();
        $client = $em->getRepository(Client::class)->find(1);


        // Static apres avec Panier
        $produit = $em->getRepository(Produit::class)->find(1);
        dump($produit);


        if ($form->isSubmitted())
        {
            $commande->setAdresse($request->request->get('commande')['adresse']);
            $commande->setDescriptionAdresse($request->request->get('commande')['descriptionAdresse']);
            $commande->setGouvernorat($request->request->get('commande')['gouvernorat']);
            $commande->setCodePostal((int)$request->request->get('commande')['codePostal']);
            $commande->setNumeroTelephone((int)$request->request->get('commande')['numeroTelephone']);
            $commande->setPrixTotal($produit->getPrix());
            $commande->setProduits($produit);

            $commande->setClient($client);

            $errors = $validator->validate($commande);
            dump($errors);
            if(count($errors)>0)
            {
                return $this->render('frontend/AjouterCommande.html.twig', ['client'=>$client,'total'=>$total_panier,
                    'form' => $form->createView(),
                    'errors'=> $errors,
                    'produit'=>$produit

                ]);
            }

            $em->persist($commande);
            $em->flush();
            /*$email = (new Email())
                ->from('anis.hajali@esprit.tn')
                ->to('omar.trabelsi.1@esprit.tn')
                //->attachFromPath('/path/to/documents/terms-of-use.pdf')
                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                //->replyTo('fabien@example.com')
                //->priority(Email::PRIORITY_HIGH)
                ->subject('Time for Symfony Mailer!')
                ->text('Bonjour nom_client \n Votre commande de : \n Produit 1 , produit 2 est passé avec succees ')
                ->html('<p>See Twig integration for better HTML integration!</p>');

            $mailer->send($email);*/

            return $this->redirectToRoute('livraison');

        }



        return $this->render('frontend/AjouterCommande.html.twig', ['client'=>$client,'total'=>$total_panier,
            'form' => $form->createView(),
            'produit'=>$produit

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
     * @Route("/paiement", name="paiement")
     */
    public function Paiemenet(): Response
    {
        return $this->render('frontend/Paiement.html.twig', [

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
    /**
     * @Route("/livraison", name="livraison")
     */
    public function Livraison(Request $request,MailerInterface $mailer): Response
    {
        $form = $this->createForm(LivraisonType::class);
        $form= $form->handleRequest($request);
        $em=$this->getDoctrine()->getManager();
        $client = $em->getRepository(Client::class)->find(1);
        $commande = $em->getRepository(Commande::class)->findBy([
            'client'=>$client->getId()
        ],[
            'REF'=>'desc'
        ]);
        $produit = $commande[0]->getProduits();


        $livraison = new Livraison();

        if($form->isSubmitted()) {
            //$livraison->setStatut("En cours");
            $livraison->setCommande($commande[0]);
            $em->persist($livraison);
            $em->flush();

            $email = (new Email())
                ->from('anis.hajali@esprit.tn')
                ->to($client->getEmail())
                ->priority(Email::PRIORITY_HIGH)
                ->subject('[Shahba] Confirmation de la Commande !')
                //->text('Sending emails is fun again!')
                ->html('<p>Bonjour cher(e) Mr/Mme '.$client->getNom().' '.$client->getPrenom().'</p><br>
                   <p>Votre Commande est bien passée. Votre Livraison est En Cours .</p><br>
                   <p>Merci pour Votre Confiance !!</p>');

            $mailer->send($email);

            return $this->redirectToRoute('paiement');
        }



        return $this->render('frontend/Livraison.html.twig', [
            'form'=>$form->createView(),
            'client'=>$client,
            'commande'=>$commande[0],

        ]);
    }
    /**
     * @Route("/mail", name="mail")
     */
    public function Mail(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('anis.hajali@esprit.tn')
            ->to('omar.trabelsi.1@esprit.tn')
            //->attachFromPath('/path/to/documents/terms-of-use.pdf')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $mailer->send($email);
        return $this->redirectToRoute('frontindex');
    }
}
