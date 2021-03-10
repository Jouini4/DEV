<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\UserAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param GuardAuthenticatorHandler $guardHandler
     * @param UserAuthenticator $authenticator
     * @return Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, UserAuthenticator $authenticator,\Swift_Mailer $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setActivationToken(md5(uniqid()));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email
            // On crée le message
            $message = (new \Swift_Message('Nouveau compte'))
                // On attribue l'expéditeur
                ->setFrom('votre@adresse.fr')
                // On attribue le destinataire
                ->setTo($user->getEmail())
                // On crée le texte avec la vue
                ->setBody(
                    $this->renderView(
                        'registration/activation.html.twig', ['token' => $user->getActivationToken()]
                    ),
                    'text/html'
                )
            ;
            $mailer->send($message);
            //return $this->redirectToRoute('frontindex');

            return $guardHandler->authenticateUserAndHandleSuccess(
            $user,
            $request,
            $authenticator,
            'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/activation/{token}" ,  name="activation")
     * @param $token
     * @param UserRepository $userRepo
     */
        public function activation($token,UserRepository $userRepo){
          $user= $userRepo->findOneBy(['activation_token'=> $token]);
          //si aucun utilisateur n'existe avec ce token
            if(!$user){
                // On renvoie une erreur 404
                //throw $this->createNotFoundException('Cet utilisateur n\'existe pas');
            }

            // On supprime le token
            $user->setActivationToken(null);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // On génère un message
            $this->addFlash('message', 'Vous avez bien activé votre compte');

            // On retourne à l'accueil
            return $this->redirectToRoute('user_index');
        }



}
