<?php

namespace NNGenie\InfosMatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\InfosMatBundle\Entity\Image;
use NNGenie\InfosMatBundle\Entity\Materiel;
use NNGenie\InfosMatBundle\Form\ImageType;

class ImageController extends Controller {

    /**
     * @Route("/images/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function imagesAction(Materiel $materiel) {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $image = new Image();
        $form = $this->createForm(new ImageType(), $image);
        $display_tab = 1;
        //selectionne les seuls images actifs
        $images = $materiel->getImages();

        return $this->render('NNGenieInfosMatBundle:Images:images.html.twig', array('images' => $images, 'form' => $form->createView(), "display_tab" => $display_tab, 'materiel' => $materiel));
    }

    /**
     * Creates a new Image entity.
     *
     * @Route("/new-image/{id}")
     * @Template()
     * @Method({"POST","GET"})
     */
    public function newAction(Materiel $materiel) {
        $image = new Image();
        $request = $this->get("request");
        $form = $this->createForm(new ImageType(), $image);
        $form->handleRequest($request);
        $repositoryImage = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Image");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($form->isSubmitted() && $form->isValid()) {
                try {
                    $image->setMateriel($materiel);
                    $repositoryImage->saveImage($image);
                    $message = $this->get('translator')->trans('Image.created_success', array(), "NNGenieInfosMatBundle");
                    $request->getSession()->getFlashBag()->add('message_success', $message);
                    return $this->redirect($this->generateUrl('nn_genie_infos_mat_materiel_detail', array("id" => $materiel->getId())));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Image.created_failure', array(), "NNGenieInfosMatBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    return $this->render('NNGenieInfosMatBundle:Images:form-add-image.html.twig', array('form' => $form->createView()));
                }
            }
            return $this->render('NNGenieInfosMatBundle:Images:form-add-image.html.twig', array('form' => $form->createView(), 'materiel' => $materiel));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_materiel_detail', array("id" => $materiel->getId())));
        }
    }

    /**
     * Finds and displays a Image entity.
     *
     * @Route("/show-image/{id}", name="post_admin_show")
     * @Method("GET")
     */
    public function showAction(Image $image) {
        $deleteForm = $this->createDeleteForm($image);

        return $this->render('image/show.html.twig', array(
                    'image' => $image,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Image entity.
     *
     * @Route("/edit-image/{id}")
     * @Template()
     * @Method({"POST","GET"})
     */
    public function editAction(Image $image) {
        // $deleteForm = $this->createDeleteForm($image);
        $request = $this->get("request");
        $editForm = $this->createForm(new ImageType(), $image);
        $editForm->handleRequest($request);
        $repositoryImage = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Image");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    $repositoryImage->updateImage($image);
                    $message = $this->get('translator')->trans('Image.updated_success', array(), "NNGenieInfosMatBundle");
                    $request->getSession()->getFlashBag()->add('message_success', $message);
                    return $this->redirect($this->generateUrl('nn_genie_infos_mat_materiel_detail', array('id' => $image->getMateriel()->getId())));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Image.updated_failure', array(), "NNGenieInfosMatBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    return $this->render('NNGenieInfosMatBundle:Images:form-update-image.html.twig', array('form' => $editForm->createView(), 'image' => $image));
                }
            }
            return $this->render('NNGenieInfosMatBundle:Images:form-update-image.html.twig', array('form' => $editForm->createView(), 'image' => $image));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_materiel_detail', array('id' => $image->getMateriel()->getId())));
        }
    }

    /**
     * Deletes a Image entity.
     *
     * @Route("/delete-image/{id}")
     * @Template()
     * @Method("GET")
     */
    public function deleteAction(Image $image) {
        $request = $this->get("request");
        $repositoryImage = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Image");
        if ($request->isMethod('GET')) {
            try {
                $repositoryImage->deleteImage($image);
                $message = $message = $this->get('translator')->trans('Image.deleted_success', array(), "NNGenieInfosMatBundle");
                $request->getSession()->getFlashBag()->add('message_success', $message);
                return $this->redirect($this->generateUrl('nn_genie_infos_mat_materiel_detail', array('id' => $image->getMateriel()->getId())));
            } catch (Exception $ex) {
                $message = $message = $this->get('translator')->trans('Image.deleted_failure', array(), "NNGenieInfosMatBundle");
                $request->getSession()->getFlashBag()->add('message_faillure', $message);
                return $this->redirect($this->generateUrl('nn_genie_infos_mat_materiel_detail', array('id' => $image->getMateriel()->getId())));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_materiel_detail', array('id' => $image->getMateriel()->getId())));
        }
    }

    /**
     * Creates a form to delete a Image entity.
     *
     * @param Image $image The Image entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Image $image) {
        return $this->createFormBuilder
                        ->setAction($this->generateUrl('post_admin_delete', array('id' => $image->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

    /**
     * Creates a form to add a Image entity.
     *
     * @param Image $image The Image entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createAddForm() {
        return $this->createFormBuilder
                        ->setAction($this->generateUrl('nn_genie_infos_mat_image_add'))
                        ->setMethod('POST')
                        ->getForm()
        ;
    }

}
