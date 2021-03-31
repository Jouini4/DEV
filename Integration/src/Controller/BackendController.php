<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Livraison;
use App\Entity\Reclamation;
use App\Entity\User;
use App\Form\CommandeType;
use App\Form\ReclamationType;
use App\Repository\AstuceRepository;
use App\Repository\TypereclamationRepository;
use App\Repository\UserRepository;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Material\ColumnChart;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\Pagination\PaginationInterface;
use App\Repository\VideoRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BackendController extends Controller
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

            array_push($d,[$res['username'],$res['Totalcommandes']]);
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
     * @Route("/back/promo", name="backpromo")
     */
    public function promo(): Response
    {
        return $this->render('backend/promo.html.twig', [

        ]);
    }
    /**
     * @Route("/back/backtraiterlivraison/{id}", name="backtraiterlivraison")
     */
    public function traiterlivraison($id,MailerInterface $mailer): Response
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $livraison=$em->getRepository(Livraison::class)->find($id);
        $livraison->setStatut("Livree");
        $commande=$livraison->getCommande();

        $livraisons = $em->getRepository(Livraison::class)->findAll();
        $email = (new Email())
            ->from('anis.hajali@esprit.tn')
            ->to($user->getEmail())
            ->priority(Email::PRIORITY_HIGH)
            ->subject('[Shahba] Commande Arrivée !')
            //->text('Sending emails is fun again!')
            ->html('<p>Bonjour cher(e) Mr/Mme '.$commande->getNom().' '.$commande->getPrenom().'</p><br>
                   <p>Votre Livraison est Livrée .</p><br>
                   <p>Merci pour Votre Confiance !!</p>');

        $mailer->send($email);


        $em->flush();

        return $this->redirectToRoute('backlivraison',[
            'livraisons'=>$livraison
        ]);
    }
    /**
     * @Route("/back/reclamation", name="backreclamation")
     */
    public function reclamation(): Response
    {
        $em=$this->getDoctrine()->getManager();
        $reclamations=$em->getRepository(Reclamation::class)->findAll();
        return $this->render('backend/reclamation.html.twig', [
            'reclamations' => $reclamations,
        ]);
    }
    /**
     * @Route("/back/utilisateur", name="backutilisateur")
     * @param UserRepository $userRepository
     * @return Response
     */
    public function utilisateur(UserRepository $userRepository,Request $request,PaginatorInterface $paginator): Response
    {
        $alluser=$this->getDoctrine()->getRepository(User::class)->findAll();
        // Paginate the results of the query
        $listuser= $paginator->paginate(
        // Doctrine Query, not results
            $alluser,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            3
        );
        //dd($listClassroom);
        return $this->render('backend/utilisateur.html.twig', [
            'controller_name' => 'BackendController','users'=>$listuser
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
     * @Route("/back/evenement", name="backevenement")
     */
    public function evenement(): Response
    {
        return $this->render('backend/evenement.html.twig', [

        ]);
    }
    /**
     * @Route("back/reclamation/{id}", name="reclamation_delete")
     */
    public function delete($id): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $reclamation=$entityManager->getRepository(reclamation::class)->find($id);
        $entityManager->remove($reclamation);
        $entityManager->flush();



        return $this->redirectToRoute('backreclamation');
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


        if ($form->isSubmitted()) {
            dump($request);
            $commande->setNom($request->request->get('commande')['nom']);
            $commande->setPrenom($request->request->get('commande')['prenom']);
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
    public function video(VideoRepository $videoRepository): Response
    {
        return $this->render('backend/video.html.twig', [
            'videos' => $videoRepository->findAll(),
        ]);
    }
    /**
     * @Route("/{id}/edit", name="reclamation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Reclamation $reclamation): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var UploadedFile $file
             */
            $file = $form->get('screenshot')->getData();
            $fileName = bin2hex(random_bytes(6)).'.'.$file->guessExtension();
            $file->move($this->getParameter('images_directory'),$fileName);
            $reclamation->setScreenshot($fileName);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backreclamation');
        }

        return $this->render('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/back/stats", name="stats")
     */
    public function statistiques(TypereclamationRepository $typRepo)
    {
        $typereclamations = $typRepo->findAll();

        $typNom = [];
        $typColor = [];
        $typCount = [];
        foreach ($typereclamations as $typereclamation){
            $typNom[] = $typereclamation->getTyrc();
            $typColor[] = $typereclamation->getColor();
            $typCount[] = count($typereclamation->getReclamations());
        }





        return $this->render('backend/stats.html.twig', [
            'typNom' => json_encode($typNom),
            'typColor' => json_encode($typColor),
            'typCount' => json_encode($typCount),
        ]);

    }
    /**
     * @Route("/back/astuce", name="backastuce")
     */
    public function astuce(AstuceRepository $astuceRepository): Response
    {
        return $this->render('backend/astuce.html.twig', [
            'astuces' => $astuceRepository->findAll(),
        ]);

    }


}
