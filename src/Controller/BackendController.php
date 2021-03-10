<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\Livraison;
use App\Form\CommandeType;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Material\ColumnChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

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
        $numCommandes = count($commandes);
        $totalCommandes =0;
        foreach($commandes as $c){
            $totalCommandes+=$c->getPrixTotal();
        }
        return $this->render('backend/commande.html.twig', [
            'commandes'=>$commandes,
            'numCommandes'=>$numCommandes,
            'totalCommandes'=>$totalCommandes

        ]);
    }
    /**
     * @Route("/back/modifiercommande/{REF}", name="backmodifiercommande")
     */
    public function Modifiercommande(Request $request,$REF,ValidatorInterface $validator): Response
    {
        $errors=null;
        // dump($request);
        $form = $this->createForm(CommandeType::class);
        $form= $form->handleRequest($request);
        $em=$this->getDoctrine()->getManager();
        $commande=$em->getRepository(Commande::class)->find($REF);


        $client = $em->getRepository(Client::class)->find($commande->getClient()->getId());
        if ($form->isSubmitted()) {
            dump($request);
            $commande->setAdresse($request->request->get('commande')['adresse']);
            $commande->setDescriptionAdresse($request->request->get('commande')['descriptionAdresse']);
            $commande->setGouvernorat($request->request->get('commande')['gouvernorat']);
            $commande->setCodePostal((int)$request->request->get('commande')['codePostal']);
            $commande->setNumeroTelephone((int)$request->request->get('commande')['numeroTelephone']);
            $errors = $validator->validate($commande);
            dump($errors);
            if (count($errors) > 0) {
                return $this->render('backend/modifiercommande.html.twig', [
                    'form' => $form->createView(),
                    'commande' => $commande,
                    'errors' => $errors

                ]);
            }


            $em->flush();

            return $this->redirectToRoute('backcommande');
        }
        return $this->render('backend/modifiercommande.html.twig', [
            'form' => $form->createView(),
            'commande' => $commande,

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
     * @Route("/back/commandestat", name="commandestat")
     */
    public function commandestat(): Response
    {

        $em=$this->getDoctrine()->getManager();
        $data = $em->getRepository(Commande::class)->findTotalCommande();

        $d = array(['Nom Client', 'Nombre Total des commandes'],
        );
        foreach ($data as $res)
        {

            array_push($d,[$res['nom']." ".$res['prenom'],$res['Totalcommandes']]);
        }








        $chart = new ColumnChart();
        $chart->getData()->setArrayToDataTable($d);

        $chart->getOptions()->getChart()
            ->setTitle('Nombre de commandes par client');

        $chart->getOptions()
            ->setBars('vertical')
            ->setHeight(400)
            ->setWidth(900)
            ->setColors(['#7570b3', '#d95f02', '#7570b3'])
            ->getVAxis()
            ->setFormat('decimal');


        return $this->render('backend/statcommande.html.twig', [
            'chart'=>$chart

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

    /**
     * @Route("/back/backtraiterlivraison/{id}", name="backtraiterlivraison")
     */
    public function traiterlivraison($id,MailerInterface $mailer): Response
    {
        $em = $this->getDoctrine()->getManager();
        $livraison=$em->getRepository(Livraison::class)->find($id);
        $livraison->setStatut("Livree");
        $client=$em->getRepository(Client::class)->find(1);
        $livraisons = $em->getRepository(Livraison::class)->findAll();
        $email = (new Email())
            ->from('anis.hajali@esprit.tn')
            ->to($client->getEmail())
            ->priority(Email::PRIORITY_HIGH)
            ->subject('[Shahba] Commande Arrivée !')
            //->text('Sending emails is fun again!')
            ->html('<p>Bonjour cher(e) Mr/Mme '.$client->getNom().' '.$client->getPrenom().'</p><br>
                   <p>Votre Livraison est Livrée .</p><br>
                   <p>Merci pour Votre Confiance !!</p>');

        $mailer->send($email);


        $em->flush();

        return $this->redirectToRoute('backlivraison',[
        'livraisons'=>$livraison
        ]);
    }


}
