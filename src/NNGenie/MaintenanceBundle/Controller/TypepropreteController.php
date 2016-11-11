<?php

namespace NNGenie\MaintenanceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\MaintenanceBundle\Entity\Typeproprete;
use NNGenie\MaintenanceBundle\Entity\Proprete;
use NNGenie\MaintenanceBundle\Form\TypepropreteType;

/**
 * Typeproprete controller.
 *
 */
class TypepropreteController extends Controller {

    /**
     * @Route("/types-proprete")
     * @Template()
     */
    public function typepropretesAction() {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryTypeproprete = $em->getRepository("NNGenieMaintenanceBundle:Typeproprete");
        $typeproprete = new Typeproprete();
        $form = $this->createForm(new TypepropreteType(), $typeproprete);
        //selectionne les seuls typepropretes materiel actifs
        $typepropretes = $repositoryTypeproprete->findBy(array("statut" => 1));

        return $this->render('NNGenieMaintenanceBundle:Typepropretes:typepropretes.html.twig', array('typepropretes' => $typepropretes, 'form' => $form->createView()));
    }

    /**
     * @Route("/type-propretes-user")
     * @Template()
     */
    public function typepropretesuserAction() {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryTypeproprete = $em->getRepository("NNGenieMaintenanceBundle:Typeproprete");
        $typeproprete = new Typeproprete();
        $form = $this->createForm(new TypepropreteType(), $typeproprete);
        $display_tab = 1;
        //selectionne les seuls typepropretes materiel actifs
        $typepropretes = $repositoryTypeproprete->findBy(array("statut" => 1));

        return $this->render('NNGenieMaintenanceBundle:FrontEnd:typeproprete.html.twig', array('typepropretes' => $typepropretes, 'form' => $form->createView(), "display_tab" => $display_tab));
    }

    /**
     * Creates a new Typeproprete entity.
     *
     * @Route("/new-type-proprete")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function newAction(Request $request) {
        $typeproprete = new Typeproprete();
        $proprete = new Proprete();
        $form = $this->createForm(new TypepropreteType(), $typeproprete);
        $form->handleRequest($request);
        $repositoryTypeproprete = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Typeproprete");
        /*$repositoryproprete = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:proprete");
        $propretes = $repositoryproprete->findBy(array("statut" => 1));*/
        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $typepropreteUnique = $repositoryTypeproprete->findBy(array("nom" => $typeproprete->getNom(), "statut" => 1));
                if ($typepropreteUnique == null) {
                    try {
                        /*foreach ($typeproprete->getpropretes() as $proprete) {
                            $proprete->setTypeproprete($typeproprete);
                        }*/
                        $repositoryTypeproprete->saveTypeproprete($typeproprete);
                        $message = $this->get('translator')->trans('Typeproprete.created_success', array(), "NNGenieMaintenanceBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                        $typeproprete = new Typeproprete();
                        $form = $this->createForm(new TypepropreteType(), $typeproprete);
                        return $this->render('NNGenieMaintenanceBundle:Typepropretes:form-add-typeproprete.html.twig', array('form' => $form->createView()));
                    } catch (Exception $ex) {
                        $message = $this->get('translator')->trans('Typeproprete.created_failure', array(), "NNGenieMaintenanceBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addError($message);
                        return $this->render('NNGenieMaintenanceBundle:Typepropretes:form-add-typeproprete.html.twig', array('form' => $form->createView()));
                    }
                } else {
                    $message = $this->get('translator')->trans('Typeproprete.exist_already', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    return $this->render('NNGenieMaintenanceBundle:Typepropretes:form-add-typeproprete.html.twig', array('form' => $form->createView()));
                }
            }
            return $this->render('NNGenieMaintenanceBundle:Typepropretes:form-add-typeproprete.html.twig', array('form' => $form->createView()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_typepropretes'));
        }
    }

    /**
     * Finds and displays a Typeproprete entity.
     *
     * @Route("/show-type-proprete/{id}", name="post_admin_show")
     * @Method({"GET"})
     */
    public function showAction(Typeproprete $typeproprete) {
        $deleteForm = $this->createDeleteForm($typeproprete);

        return $this->render('typeproprete/show.html.twig', array(
                    'typeproprete' => $typeproprete,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Typeproprete entity.
     *
     * @Route("/edit-type-proprete/{id}")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function editAction(Request $request, Typeproprete $typeproprete) {
        $proprete = new Proprete();
        $editForm = $this->createForm(new TypepropreteType(), $typeproprete);
        $editForm->handleRequest($request);
        $repositoryTypeproprete = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Typeproprete");
        $repositoryproprete = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:proprete");
        /*$othersPropretes = new \Doctrine\Common\Collections\ArrayCollection();
        $originalpropretes = new \Doctrine\Common\Collections\ArrayCollection();
        $propretes = $repositoryproprete->findBy(array("statut" => 1));
        foreach ($propretes as $proprete) {
            if (!$typeproprete->getpropretes()->contains($proprete)) {
                $othersPropretes->add($proprete);
            }
        }*/
        
        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    // remove the relationship between the tag and the Task
                    /*foreach ($originalpropretes as $proprete) {
                        if (false === $typeproprete->getpropretes()->contains($proprete)) {
                            // remove the typeproprete from the proprete
                            //$proprete->getTypepropretes()->removeElement($typeproprete);
                            // if it was a many-to-one relationship, remove the relationship like this

                            $repositoryproprete->deleteproprete($proprete);

                            // if you wanted to delete the proprete entirely, you can also do that
                            // $em->remove($proprete);
                        }
                    }*/
                    $repositoryTypeproprete->updateTypeproprete($typeproprete);
                    $message = $this->get('translator')->trans('Typeproprete.updated_success', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                    return $this->redirect($this->generateUrl('nn_genie_maintenance_typepropretes'));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Typeproprete.updated_failure', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    return $this->render('NNGenieMaintenanceBundle:Typepropretes:form-update-typeproprete.html.twig', array('form' => $editForm->createView(), 'idtypeproprete' => $typeproprete->getId()));
                }
            }
            /*foreach ($typeproprete->getpropretes() as $proprete) {
                $originalpropretes->add($proprete);
            }*/
            return $this->render('NNGenieMaintenanceBundle:Typepropretes:form-update-typeproprete.html.twig', array('form' => $editForm->createView(), 'idtypeproprete' => $typeproprete->getId()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_typepropretes'));
        }
    }

    /**
     * Deletes a Typeproprete entity.
     *
     * @Route("/delete-type-proprete/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function deleteAction(Typeproprete $typeproprete) {
        $request = $this->get("request");
        $repositoryTypeproprete = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Typeproprete");
        $repositoryproprete = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:proprete");
        $proprete = new Proprete();
        if ($request->isMethod('GET')) {
            try {
                foreach ($typeproprete->getpropretes() as $proprete) {
                    $repositoryproprete->deleteproprete($proprete);
                }
                $repositoryTypeproprete->deleteTypeproprete($typeproprete);
                $message = $this->get('translator')->trans('Typeproprete.deleted_success', array(), "NNGenieMaintenanceBundle");
                $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                return $this->redirect($this->generateUrl('nn_genie_maintenance_typepropretes'));
            } catch (Exception $ex) {
                $message = $this->get('translator')->trans('Typeproprete.updated_failure', array(), "NNGenieMaintenanceBundle");
                $this->get('ras_flash_alert.alert_reporter')->addError($message);
                return $this->redirect($this->generateUrl('nn_genie_maintenance_typepropretes'));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_typepropretes'));
        }
    }

}
