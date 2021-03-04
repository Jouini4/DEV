<?php

namespace App\Controller;

use App\Form\ModiferUserType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepository;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\configuration\IsGranted;



/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     *@IsGranted("ROLE_ADMIN")
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('backend/admin.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * liste des utilisateurs du site
     * @Route("/utilisateurs", name="utilisateurs")
     * @param UserRepository $user
     * @return Response
     */
    public function userList(UserRepository  $user){
        return $this->render('backend/utilisateur.html.twig', [
           'user'=>$user->findAll()
        ]);

    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * modifier  les utilisateurs du site
     * @Route("/utilisateurs/modifier/{id}", name="modifier_utilisateur")
     * @param Request $request
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editUser( Request $request,int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = $entityManager->getRepository(user::class)->find($id);
        $form = $this->createForm(ModiferUserType::class, $user);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->flush();

            $this->addFlash('message', 'Utilisateur modifié avec succès');
            return $this->redirectToRoute('utilisateurs');
        }

        return $this->render('admin/modifierUser.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/utilisateurs/supprimer/{id}", name="supprimer_utilisateur")
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(user::class)->find($id);
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute("utilisateurs");
    }
}
