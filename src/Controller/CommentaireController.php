<?php

namespace App\Controller;

use App\Entity\Astuce;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class CommentaireController extends AbstractController
{
    /**
     * Lists all commentaire entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commentaires = $em->getRepository(Commentaire::class)->findAll();

        return $this->render('commentaire/index.html.twig', [
            'commentaires' => $commentaires,
        ]);
    }

    /**
     * Finds and displays a commentaire entity.
     * @param Commentaire $commentaire
     * @return Response
     */
    public function showAction(Commentaire $commentaire)
    {
        $deleteForm = $this->createDeleteForm($commentaire);

        return $this->render('commentaire/show.html.twig', array(
            'commentaire' => $commentaire,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing commentaire entity.
     */
    public function editAction(Request $request, Commentaire $commentaire)
    {
        $this->createDeleteForm($commentaire);
        $editForm = $this->createForm(CommentaireType::class, $commentaire);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return new Response($commentaire->getId());
            /*return $this->redirectToRoute('commentaire_edit', array('id' => $commentaire->getId()));*/
        }

        return new Response("");
    }

    /**
     * Deletes a commentaire entity
     * @param Request $request
     * @param Commentaire $commentaire
     * @return Response
     */
    public function deleteAction(Request $request, Commentaire $commentaire)
    {
        $user = $this->getUser() ;
        $em = $this->getDoctrine()->getManager();
        $commentaire = $em->getRepository(Commentaire::class)->findAll();

        if ($commentaire && ($commentaire->getUseridastuce()->getId() == $user->getId() || $user->isSuperAdmin()) ) {
            $em->remove($commentaire);
            $em->flush();
        }

        return new Response("");
    }

    /**
     * Creates a form to delete a commentaire entity.
     *
     * @param Commentaire $commentaire The commentaire entity
     *
     * @return FormInterface The form
     */
    private function createDeleteForm(Commentaire $commentaire)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('commentaire_delete', array('id' => $commentaire->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    public function viewCommentsAction($id_astuce)
    {
        $em = $this->getDoctrine()->getManager();

        $commentaires = $em->getRepository(Commentaire::class)->findBy(array("astuce_id"=>$id_astuce));

        return $this->render('commentaire/admin_view_comments.html.twig', array(
            'commentaires' => $commentaires,
        ));
    }
}
