<?php

namespace NNGenie\MaintenanceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\MaintenanceBundle\Entity\Panne;
use NNGenie\MaintenanceBundle\Entity\Piece;
use NNGenie\MaintenanceBundle\Form\PanneType;
use NNGenie\MaintenanceBundle\Entity\Question;

/**
 * Panne controller.
 *
 */
class PanneController extends Controller {

    /**
     * @Route("/pannes")
     * @Template()
     */
    public function pannesAction() {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryPanne = $em->getRepository("NNGenieMaintenanceBundle:Panne");
        $panne = new Panne();
        $form = $this->createForm(new PanneType(), $panne);
        //selectionne les seuls pannes materiel actifs
        $pannes = $repositoryPanne->findBy(array("statut" => 1));

        return $this->render('NNGenieMaintenanceBundle:Pannes:pannes.html.twig', array('pannes' => $pannes, 'form' => $form->createView()));
    }

    /**
     * @Route("/pannes-user")
     * @Template()
     */
    public function pannesuserAction() {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryPanne = $em->getRepository("NNGenieMaintenanceBundle:Panne");
        $panne = new Panne();
        $form = $this->createForm(new PanneType(), $panne);
        $display_tab = 1;
        //selectionne les seuls pannes materiel actifs
        $pannes = $repositoryPanne->findBy(array("statut" => 1));

        return $this->render('NNGenieMaintenanceBundle:FrontEnd:panne.html.twig', array('pannes' => $pannes, 'form' => $form->createView(), "display_tab" => $display_tab));
    }

    /**
     * Creates a new Panne entity.
     *
     * @Route("/new-panne")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function newAction(Request $request) {
        $panne = new Panne();
        $panneUnique = new Panne();
        $form = $this->createForm(new PanneType(), $panne);
        $form->handleRequest($request);
        $repositoryPanne = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Panne");
        $repositoryPiece = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Piece");
        $repositoryQuestion = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Question");
        $repositoryOperation = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Operation");
        $repositoryTest= $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Test");
        $pieces = $repositoryPiece->findBy(array("statut" => 1));
        $questions = $repositoryQuestion->findBy(array("statut" => 1));
        $operations = $repositoryOperation->findBy(array("statut" => 1));
        $tests = $repositoryTest->findBy(array("statut" => 1));
        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $panneUnique = $repositoryPanne->findBy(array("nom" => $panne->getNom(), "statut" => 1));
                if ($panneUnique == null) {
                    try {
                        $idpieces = $request->request->get("idpieces");
                        $idquestions = $request->request->get("idquestions");
                        $idoperations = $request->request->get("idoperations");
                        $idtests = $request->request->get("idtests");
                        //add others exists pieces to a panne
                        if ($idpieces && is_array($idpieces) && !empty($idpieces)) {
                            foreach ($idpieces as $idpiece) {
                                $idpiece = (int) $idpiece;
                                $piece = $repositoryPiece->find($idpiece);
                                if (false === $panne->getPieces()->contains($piece)) {
                                    $panne->getPieces()->add($piece);
                                    $piece->getPannes()->add($panne);
                                    $repositoryPiece->updatePiece($piece);
                                }
                            }
                        }
                        //add others exists questions to a panne
                        if ($idquestions && is_array($idquestions) && !empty($idquestions)) {
                            foreach ($idquestions as $idquestion) {
                                $idquestion = (int) $idquestion;
                                $question = $repositoryQuestion->find($idquestion);
                                if (false === $panne->getQuestions()->contains($question)) {
                                    $panne->getQuestions()->add($question);
                                    $question->getPannes()->add($panne);
                                    $repositoryQuestion->updateQuestion($question);
                                }
                            }
                        }
                        //add others exists operations to a panne
                        if ($idoperations && is_array($idoperations) && !empty($idoperations)) {
                            foreach ($idoperations as $idoperation) {
                                $idoperation = (int) $idoperation;
                                $operation = $repositoryOperation->find($idoperation);
                                if (false === $panne->getOperations()->contains($operation)) {
                                    $panne->getOperations()->add($operation);
                                    $operation->getPannes()->add($panne);
                                    $repositoryOperation->updateOperation($operation);
                                }
                            }
                        }
                        //add others exists tests to a panne
                        if ($idtests && is_array($idtests) && !empty($idtests)) {
                            foreach ($idtests as $idtest) {
                                $idtest = (int) $idtest;
                                $test = $repositoryTest->find($idtest);
                                if (false === $panne->getTests()->contains($test)) {
                                    $panne->getTests()->add($test);
                                    $test->getPannes()->add($panne);
                                    $repositoryTest->updateTest($test);
                                }
                            }
                        }
                        $repositoryPanne->savePanne($panne);
                        $message = $this->get('translator')->trans('Panne.created_success', array(), "NNGenieMaintenanceBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                        $panne = new Panne();
                        $form = $this->createForm(new PanneType(), $panne);
                        return $this->render('NNGenieMaintenanceBundle:Pannes:form-add-panne.html.twig', array('form' => $form->createView(), 'pieces' => $pieces, 'questions' => $questions, 'operations' => $operations, 'tests' => $tests));
                    } catch (Exception $ex) {
                        $message = $this->get('translator')->trans('Panne.created_failure', array(), "NNGenieMaintenanceBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addError($message);
                        return $this->render('NNGenieMaintenanceBundle:Pannes:form-add-panne.html.twig', array('form' => $form->createView(), 'pieces' => $pieces, 'questions' => $questions, 'operations' => $operations, 'tests' => $tests));
                    }
                } else {
                    $message = $this->get('translator')->trans('Panne.exist_already', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    return $this->render('NNGenieMaintenanceBundle:Pannes:form-add-panne.html.twig', array('form' => $form->createView(), 'pieces' => $pieces, 'questions' => $questions, 'operations' => $operations, 'tests' => $tests));
                }
            }
            return $this->render('NNGenieMaintenanceBundle:Pannes:form-add-panne.html.twig', array('form' => $form->createView(), 'pieces' => $pieces, 'questions' => $questions, 'operations' => $operations, 'tests' => $tests));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_pannes'));
        }
    }

    /**
     * Finds and displays a Panne entity.
     *
     * @Route("/show-panne/{id}", name="post_admin_show")
     * @Method({"GET"})
     */
    public function showAction(Panne $panne) {
        $deleteForm = $this->createDeleteForm($panne);

        return $this->render('panne/show.html.twig', array(
                    'panne' => $panne,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Panne entity.
     *
     * @Route("/edit-panne/{id}")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function editAction(Request $request, Panne $panne) {
        $piece = new Piece();
        $question = new Question();
        $editForm = $this->createForm(new PanneType(), $panne);
        $editForm->handleRequest($request);
        $repositoryPanne = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Panne");
        $repositoryPiece = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Piece");
        $repositoryQuestion = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Question");
        $repositoryOperation = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Operation");
        $repositoryTest = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Test");
        $originalPieces = new \Doctrine\Common\Collections\ArrayCollection();
        $originalQuestions = new \Doctrine\Common\Collections\ArrayCollection();
        $originalOperations = new \Doctrine\Common\Collections\ArrayCollection();
        $originalTests= new \Doctrine\Common\Collections\ArrayCollection();
        $othersPieces = new \Doctrine\Common\Collections\ArrayCollection();
        $othersQuestions = new \Doctrine\Common\Collections\ArrayCollection();
        $othersOperations = new \Doctrine\Common\Collections\ArrayCollection();
        $othersTests = new \Doctrine\Common\Collections\ArrayCollection();
        $pieces = $repositoryPiece->findBy(array("statut" => 1));
        $questions = $repositoryQuestion->findBy(array("statut" => 1));
        $operations = $repositoryOperation->findBy(array("statut" => 1));
        $tests = $repositoryTest->findBy(array("statut" => 1));
        foreach ($pieces as $piece) {
            if (!$panne->getPieces()->contains($piece)) {
                $othersPieces->add($piece);
            }
        }
        foreach ($questions as $question) {
            if (!$panne->getQuestions()->contains($question)) {
                $othersQuestions->add($question);
            }
        }
        
        foreach ($operations as $operation) {
            if (!$panne->getOperations()->contains($operation)) {
                $othersOperations->add($operation);
            }
        }
        foreach ($tests as $test) {
            if (!$panne->getTests()->contains($test)) {
                $othersTests->add($test);
            }
        }
        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    $idpieces = $request->request->get("idpieces");
                    $idquestions = $request->request->get("idquestions");
                    $idoperations = $request->request->get("idoperations");
                    $idtests = $request->request->get("idtests");
                    // remove the relationship between the tag and the Task
                    foreach ($originalPieces as $piece) {
                        if (false === $panne->getPieces()->contains($piece)) {
                            // remove the panne from the piece
                            $piece->getPannes()->removeElement($panne);

                            // if it was a many-to-one relationship, remove the relationship like this
                            // $piece->setPanne(null);

                            $repositoryPiece->updatePiece($piece);

                            // if you wanted to delete the Piece entirely, you can also do that
                            // $em->remove($piece);
                        }
                    }
                    //add others exists pieces to a panne
                    if ($idpieces && is_array($idpieces) && !empty($idpieces)) {
                        foreach ($idpieces as $idpiece) {
                            $idpiece = (int) $idpiece;
                            $piece = $repositoryPiece->find($idpiece);
                            if (false === $panne->getPieces()->contains($piece)) {
                                $panne->getPieces()->add($piece);
                                $piece->getPannes()->add($panne);
                                $repositoryPiece->updatePiece($piece);
                            }
                        }
                    }
                    foreach ($originalQuestions as $question) {
                        if (false === $panne->getQuestions()->contains($question)) {
                            // remove the panne from the piece
                            $question->getPannes()->removeElement($panne);
                            $repositoryQuestion->updateQuestion($question);
                        }
                    }

                    //add others exists questions to a panne
                    if ($idquestions && is_array($idquestions) && !empty($idquestions)) {
                        foreach ($idquestions as $idquestion) {
                            $idquestion = (int) $idquestion;
                            $question = $repositoryQuestion->find($idquestion);
                            if (false === $panne->getQuestions()->contains($question)) {
                                $panne->getQuestions()->add($question);
                                $question->getPannes()->add($panne);
                                $repositoryQuestion->updateQuestion($question);
                            }
                        }
                    }
                    
                    foreach ($originalOperations as $operation) {
                        if (false === $panne->getOperations()->contains($operation)) {
                            // remove the panne from the piece
                            $operation->getPannes()->removeElement($panne);
                            $repositoryOperation->updateOperation($operation);
                        }
                    }

                    //add others exists operations to a panne
                    if ($idoperations && is_array($idoperations) && !empty($idoperations)) {
                        foreach ($idoperations as $idoperation) {
                            $idoperation = (int) $idoperation;
                            $operation = $repositoryOperation->find($idoperation);
                            if (false === $panne->getOperations()->contains($operation)) {
                                $panne->getOperations()->add($operation);
                                $operation->getPannes()->add($panne);
                                $repositoryOperation->updateOperation($operation);
                            }
                        }
                    }
                    
                    foreach ($originalTests as $test) {
                        if (false === $panne->getTests()->contains($test)) {
                            // remove the panne from the piece
                            $test->getPannes()->removeElement($panne);
                            $repositoryTest->updateTest($test);
                        }
                    }

                    //add others exists tests to a panne
                    if ($idtests && is_array($idtests) && !empty($idtests)) {
                        foreach ($idtests as $idtest) {
                            $idtest = (int) $idtest;
                            $test = $repositoryTest->find($idtest);
                            if (false === $panne->getTests()->contains($test)) {
                                $panne->getTests()->add($test);
                                $operation->getPannes()->add($panne);
                                $repositoryTest->updateTest($test);
                            }
                        }
                    }

                    $repositoryPanne->updatePanne($panne);
                    $message = $this->get('translator')->trans('Panne.updated_success', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                    return $this->redirect($this->generateUrl('nn_genie_maintenance_pannes'));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Panne.updated_failure', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    return $this->render('NNGenieMaintenanceBundle:Pannes:form-update-panne.html.twig', array('form' => $editForm->createView(), 'panne' => $panne, 'pieces' => $othersPieces, 'questions' => $othersQuestions, 'operations' => $othersOperations, 'tests' => $othersTests));
                }
            }
            foreach ($panne->getPieces() as $piece) {
                $originalPieces->add($piece);
            }
            foreach ($panne->getQuestions() as $question) {
                $originalQuestions->add($question);
            }
            foreach ($panne->getOperations() as $operation) {
                $originalOperations->add($operation);
            }
            foreach ($panne->getTests() as $test) {
                $originalTests->add($test);
            }
            return $this->render('NNGenieMaintenanceBundle:Pannes:form-update-panne.html.twig', array('form' => $editForm->createView(), 'panne' => $panne, 'pieces' => $othersPieces, 'questions' => $othersQuestions, 'operations' => $othersOperations, 'tests' => $othersTests));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_pannes'));
        }
    }

    /**
     * Deletes a Panne entity.
     *
     * @Route("/delete-panne/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function deleteAction(Panne $panne) {
        $request = $this->get("request");
        $repositoryPanne = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Panne");
        $repositoryPiece = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Piece");
        $repositoryQuestion = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Question");
        $repositoryOperation = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Operation");
        $repositoryTest = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Test");
        $piece = new Piece();
        $question = new Question();
        if ($request->isMethod('GET')) {
            try {
                foreach ($panne->getPieces() as $piece) {
                    $piece->getPannes()->removeElement($panne);
                    $repositoryPiece->updatePiece($piece);
                }
                foreach ($panne->getQuestions() as $question) {
                    $question->getPannes()->removeElement($panne);
                    $repositoryQuestion->updateQuestion($question);
                }
                foreach ($panne->getOperations() as $operation) {
                    $operation->getPannes()->removeElement($panne);
                    $repositoryOperation->updateOperation($operation);
                }
                foreach ($panne->getTests() as $test) {
                    $test->getPannes()->removeElement($panne);
                    $repositoryTest->updateTest($test);
                }
                $repositoryPanne->deletePanne($panne);
                $message = $this->get('translator')->trans('Panne.deleted_success', array(), "NNGenieMaintenanceBundle");
                $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                return $this->redirect($this->generateUrl('nn_genie_maintenance_pannes'));
            } catch (Exception $ex) {
                $message = $this->get('translator')->trans('Panne.updated_failure', array(), "NNGenieMaintenanceBundle");
                $this->get('ras_flash_alert.alert_reporter')->addError($message);
                return $this->redirect($this->generateUrl('nn_genie_maintenance_pannes'));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_pannes'));
        }
    }

}
