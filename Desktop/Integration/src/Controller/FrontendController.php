<?php

namespace App\Controller;

use App\Entity\Astuce;
use App\Entity\Reclamation;
use App\Entity\User;
use App\Entity\Commande;
use App\Entity\Livraison;
use App\Entity\Produit;
use App\Form\CommandeType;
use App\Form\LivraisonType;
use App\Form\ReclamationType;
use App\Repository\AstuceRepository;
use App\Repository\ProduitRepository;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Snappy\Pdf;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


Stripe::setApiKey('sk_test_51IZJ1EKIRZuutEl1maEN8DKdzIwfjxfLEbof9NyFFcEz2PNbi8xScVt2m0Lhq7i4RmKxf96m6xIAmwluqVAul3lQ00DlU2Kr7B');


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
     * @Security("is_granted('ROLE_USER')")
     */
    public function AddCommande(Request $request,ValidatorInterface $validator,SessionInterface $session, ProduitRepository $produitRepository): Response
    {
        $panier = $session->get('panier');
        $panierwithData = [];
        foreach ($panier as $id => $quantite){

                $panierwithData[] = [
                    'produit' => $produitRepository->find($id),
                    'quantite' => $quantite
                ];


        }



        $errors = null;
        dump($panierwithData);
        $form = $this->createForm(CommandeType::class);
        $form= $form->handleRequest($request);

        // $Panier = $em->getRepository(Panier::class)->find(1)
        // boucle : somme
        $total_panier = 750;
        $em=$this->getDoctrine()->getManager();
      //  $user = $em->getRepository(User::class)->find(1);
        $user = $this->get('security.token_storage')->getToken()->getUser();

        // Static apres avec Panier
      /*  $produit = $em->getRepository(Produit::class)->find(1);
        dump($produit);*/
    $total=0;
        foreach ($panierwithData as $panierd) {
            $totalPanier = $panierd['produit']->getPrix() * $panierd['quantite'];
            $total += $totalPanier;
        }
        if ($form->isSubmitted())
        {

            foreach ($panierwithData as $panierd) {
                $commande = new Commande();
                $commande->setNom($request->request->get('commande')['nom']);
                $commande->setPrenom($request->request->get('commande')['prenom']);
                $commande->setAdresse($request->request->get('commande')['adresse']);
                $commande->setDescriptionAdresse($request->request->get('commande')['descriptionAdresse']);
                $commande->setGouvernorat($request->request->get('commande')['gouvernorat']);
                $commande->setCodePostal((int)$request->request->get('commande')['codePostal']);
                $commande->setNumeroTelephone((int)$request->request->get('commande')['numeroTelephone']);
                $commande->setProduits($panierd['produit']);
                $commande->setPrixTotal($total);

                $commande->setUser($user);
                $errors = $validator->validate($commande);
                dump($errors);
                if(count($errors)>0)
                {
                    return $this->render('frontend/AjouterCommande.html.twig', ['user'=>$user,
                        'form' => $form->createView(),
                        'errors'=> $errors,
                        'total'=>$total,
                        'panierD' => $panierwithData


                    ]);
                }

                $em->persist($commande);
                $em->flush();
            }



            /*$email = (new Email())
                ->from('anis.hajali@esprit.tn')
                ->to('omar.trabelsi.1@esprit.tn')
                //->attachFromPath('/path/to/documents/terms-of-use.pdf')
                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                //->replyTo('fabien@example.com')
                //->priority(Email::PRIORITY_HIGH)
                ->subject('Time for Symfony Mailer!')
                ->text('Bonjour nom_User \n Votre commande de : \n Produit 1 , produit 2 est passé avec succees ')
                ->html('<p>See Twig integration for better HTML integration!</p>');

            $mailer->send($email);*/

            return $this->redirectToRoute('livraison');

        }



        return $this->render('frontend/AjouterCommande.html.twig', ['user'=>$user,
            'form' => $form->createView(),
            'total'=>$total,
            'panierD' => $panierwithData


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
    public function AstuceP(AstuceRepository $astuceRepository,PaginatorInterface $paginator,Request $request): Response
    {
        $allAstuce=$this->getDoctrine()->getRepository(Astuce::class)->findAll();
        // Paginate the results of the query
        $listAstuce= $paginator->paginate(
        // Doctrine Query, not results
            $allAstuce,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            3
        );
        //dd($listClassroom);
        return $this->render('frontend/AstuceProduit.html.twig', [
            'controller_name' => 'AstuceController','astuces'=>$listAstuce
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
     * @Security("is_granted('ROLE_USER')")
     */
    public function Paiemenet(): Response
    {
        $em=$this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $commande = $em->getRepository(Commande::class)->findBy([
            'user'=>$user->getId()
        ],[
            'REF'=>'desc'
        ]);

        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $commande[0]->getprixTotal()*100,
            'currency' => 'usd',
        ]);

        $output = [
            'clientSecret' => $paymentIntent->client_secret,
        ];

        return $this->render('frontend/Paiement.html.twig', [

        ]);
    }

    /**
     * @Route("/paiementapi", name="paiementapi")
     */
    public function Paiemenetapi(): Response
    {
        $em=$this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $commande = $em->getRepository(Commande::class)->findBy([
            'user'=>$user->getId()
        ],[
            'REF'=>'desc'
        ]);

        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $commande[0]->getprixTotal()*100,
            'currency' => 'usd',
        ]);

        $output = [
            'clientSecret' => $paymentIntent->client_secret,
        ];

        return new JsonResponse($output);
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
     * @Security("is_granted('ROLE_USER')")
     */
    public function reclamation(Request $request,MailerInterface $mailer): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->add("ajouter",SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var UploadedFile $file
             */
            $file = $form->get('screenshot')->getData();
            $fileName = bin2hex(random_bytes(6)).'.'.$file->guessExtension();
            $file->move($this->getParameter('images_directory'),$fileName);
            $reclamation->setScreenshot($fileName);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reclamation);
            $entityManager->flush();
            $email = (new Email())
                ->from('cyrine.khezami@esprit.tn')
                ->to($reclamation->getMailc())
                ->priority(Email::PRIORITY_HIGH)
                ->subject('[Shahba] Traitement de reclamation !')
                //->text('Sending emails is fun again!')
                ->html('<p>Bonjour cher(e) Mr/Mme '.$reclamation->getNomc().' '.$reclamation->getPnomc().'</p><br>
                   <p>Votre Reclamation est bien passée.</p><br>');
            $mailer->send($email);

            return $this->redirectToRoute('reclamation_index');
        }

        return $this->render('frontend/Reclamation.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ]);

    }



    /**
     * @Route("/livraison", name="livraison")
     * @Security("is_granted('ROLE_USER')")
     */
    public function Livraison(Request $request,MailerInterface $mailer): Response
    {
        $form = $this->createForm(LivraisonType::class);
        $form= $form->handleRequest($request);
        $em=$this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find(1);
        $commande = $em->getRepository(Commande::class)->findBy([
            'user'=>$user->getId()
        ],[
            'REF'=>'desc'
        ]);
        $produit = $commande[0]->getProduits();


        $livraison = new Livraison();
        $YOUR_DOMAIN = 'http://localhost:8000';
        if($form->isSubmitted()) {
            //$livraison->setStatut("En cours");
            $livraison->setCommande($commande[0]);
            $em->persist($livraison);
            $em->flush();




            $email = (new Email())
                ->from('cyrine.khezami@esprit.tn')
                ->to($user->getEmail())
                ->priority(Email::PRIORITY_HIGH)
                ->subject('[Shahba] Confirmation de la Commande !')
                //->text('Sending emails is fun again!')
                ->html('<p>Bonjour cher(e) Mr/Mme '.$commande[0]->getNom().' '.$commande[0]->getPrenom().'</p><br>
                   <p>Votre Commande a été bien passée. Votre Livraison est En Cours .</p><br>
                   <p>Merci pour Votre Confiance !!</p>');
            $mailer->send($email);

            return $this->redirectToRoute('paiement');
        }



        return $this->render('frontend/Livraison.html.twig', [
            'form'=>$form->createView(),
            'user'=>$user,
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

    /**
     * @Route ("/pdflivraison", name="pdflivraison")
     * @Security("is_granted('ROLE_USER')")
     */
    public function PdfLivraison(Pdf $knpSnappyPdf)
    {

        $em=$this->getDoctrine()->getManager();
        $user = $em->getRepository(user::class)->find(1);
        $commande = $em->getRepository(Commande::class)->findBy([
            'user'=>$user->getId()
        ],[
            'REF'=>'desc'
        ]);
        $html = $this->renderView('frontend/PdfLivraison.html.twig', array(
            'user'=>$user,
            'commande'=>$commande[0],
        ));

        return new PdfResponse(
            $knpSnappyPdf->getOutputFromHtml($html),
            'Livraison.pdf'
        );
    }

}
