<?php

namespace NNGenie\InfosMatBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use NNGenie\InfosMatBundle\Entity\Materiel;
use NNGenie\InfosMatBundle\Form\MaterielType;

/**
 * Materiel controller.
 *
 * @Route("/post_admin")
 */
class MaterielController extends Controller
{
    /**
     * Lists all Materiel entities.
     *
     * @Route("/", name="post_admin_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $materiels = $em->getRepository('NNGenieInfosMatBundle:Materiel')->findAll();

        return $this->render('materiel/index.html.twig', array(
            'materiels' => $materiels,
        ));
    }

    /**
     * Creates a new Materiel entity.
     *
     * @Route("/new", name="post_admin_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $materiel = new Materiel();
        $form = $this->createForm('NNGenie\InfosMatBundle\Form\MaterielType', $materiel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($materiel);
            $em->flush();

            return $this->redirectToRoute('post_admin_show', array('id' => $materiel->getId()));
        }

        return $this->render('materiel/new.html.twig', array(
            'materiel' => $materiel,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Materiel entity.
     *
     * @Route("/{id}", name="post_admin_show")
     * @Method("GET")
     */
    public function showAction(Materiel $materiel)
    {
        $deleteForm = $this->createDeleteForm($materiel);

        return $this->render('materiel/show.html.twig', array(
            'materiel' => $materiel,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Materiel entity.
     *
     * @Route("/{id}/edit", name="post_admin_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Materiel $materiel)
    {
        $deleteForm = $this->createDeleteForm($materiel);
        $editForm = $this->createForm('NNGenie\InfosMatBundle\Form\MaterielType', $materiel);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($materiel);
            $em->flush();

            return $this->redirectToRoute('post_admin_edit', array('id' => $materiel->getId()));
        }

        return $this->render('materiel/edit.html.twig', array(
            'materiel' => $materiel,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Materiel entity.
     *
     * @Route("/{id}", name="post_admin_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Materiel $materiel)
    {
        $form = $this->createDeleteForm($materiel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($materiel);
            $em->flush();
        }

        return $this->redirectToRoute('post_admin_index');
    }

    /**
     * Creates a form to delete a Materiel entity.
     *
     * @param Materiel $materiel The Materiel entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Materiel $materiel)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('post_admin_delete', array('id' => $materiel->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
