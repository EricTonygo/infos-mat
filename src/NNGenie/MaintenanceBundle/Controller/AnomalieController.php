<?php

namespace NNGenie\MaintenanceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\MaintenanceBundle\Entity\Anomalie;
use NNGenie\MaintenanceBundle\Form\AnomalieType;
use NNGenie\MaintenanceBundle\Entity\Question;

/**
 * Anomalie controller.
 *
 */
class AnomalieController extends Controller {

    /**
     * @Route("/anomalies")
     * @Template()
     */
    public function anomaliesAction() {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          }
        $em = $this->getDoctrine()->getManager();

        $repositoryAnomalie = $em->getRepository("NNGenieMaintenanceBundle:Anomalie");
        $anomalie = new Anomalie();
        $form = $this->createForm(new AnomalieType(), $anomalie);
        //selectionne les seuls anomalies materiel actifs
        $anomalies = $repositoryAnomalie->findBy(array("statut" => 1));

        return $this->render('NNGenieMaintenanceBundle:Anomalies:anomalies.html.twig', array('anomalies' => $anomalies, 'form' => $form->createView()));
    }

    /**
     * @Route("/anomalies-user")
     * @Template()
     */
    public function anomaliesuserAction() {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } 
        $em = $this->getDoctrine()->getManager();

        $repositoryAnomalie = $em->getRepository("NNGenieMaintenanceBundle:Anomalie");
        $anomalie = new Anomalie();
        $form = $this->createForm(new AnomalieType(), $anomalie);
        $display_tab = 1;
        //selectionne les seuls anomalies materiel actifs
        $anomalies = $repositoryAnomalie->findBy(array("statut" => 1));

        return $this->render('NNGenieMaintenanceBundle:FrontEnd:anomalie.html.twig', array('anomalies' => $anomalies, 'form' => $form->createView()));
    }

    /**
     * Creates a new Anomalie entity.
     *
     * @Route("/new-anomalie")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function newAction(Request $request) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $anomalie = new Anomalie();
        $anomalieUnique = new Anomalie();
        $form = $this->createForm(new AnomalieType(), $anomalie);
        $form->handleRequest($request);
        $repositoryAnomalie = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Anomalie");
        $repositoryQuestion = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Question");
        $repositoryOperation = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Operation");
        $repositoryTest= $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Test");
        $questions = $repositoryQuestion->findBy(array("statut" => 1));
        $operations = $repositoryOperation->findBy(array("statut" => 1));
        $tests = $repositoryTest->findBy(array("statut" => 1));
        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $anomalieUnique = $repositoryAnomalie->findBy(array("nom" => $anomalie->getNom(), "statut" => 1));
                if ($anomalieUnique == null) {
                    try {
                        $idquestions = $request->request->get("idquestions");
                        $idoperations = $request->request->get("idoperations");
                        $idtests = $request->request->get("idtests");
                        //add others exists questions to a anomalie
                        if ($idquestions && is_array($idquestions) && !empty($idquestions)) {
                            foreach ($idquestions as $idquestion) {
                                $idquestion = (int) $idquestion;
                                $question = $repositoryQuestion->find($idquestion);
                                if (false === $anomalie->getQuestions()->contains($question)) {
                                    $anomalie->getQuestions()->add($question);
                                    $question->getAnomalies()->add($anomalie);
                                    $repositoryQuestion->updateQuestion($question);
                                }
                            }
                        }
                        //add others exists operations to a anomalie
                        if ($idoperations && is_array($idoperations) && !empty($idoperations)) {
                            foreach ($idoperations as $idoperation) {
                                $idoperation = (int) $idoperation;
                                $operation = $repositoryOperation->find($idoperation);
                                if (false === $anomalie->getOperations()->contains($operation)) {
                                    $anomalie->getOperations()->add($operation);
                                    $operation->getAnomalies()->add($anomalie);
                                    $repositoryOperation->updateOperation($operation);
                                }
                            }
                        }
                        //add others exists tests to a anomalie
                        if ($idtests && is_array($idtests) && !empty($idtests)) {
                            foreach ($idtests as $idtest) {
                                $idtest = (int) $idtest;
                                $test = $repositoryTest->find($idtest);
                                if (false === $anomalie->getTests()->contains($test)) {
                                    $anomalie->getTests()->add($test);
                                    $test->getAnomalies()->add($anomalie);
                                    $repositoryTest->updateTest($test);
                                }
                            }
                        }
                        $repositoryAnomalie->saveAnomalie($anomalie);
                        $message = $this->get('translator')->trans('Anomalie.created_success', array(), "NNGenieMaintenanceBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                        $anomalie = new Anomalie();
                        $form = $this->createForm(new AnomalieType(), $anomalie);
                        return $this->render('NNGenieMaintenanceBundle:Anomalies:form-add-anomalie.html.twig', array('form' => $form->createView(), 'questions' => $questions, 'operations' => $operations, 'tests' => $tests));
                    } catch (Exception $ex) {
                        $message = $this->get('translator')->trans('Anomalie.created_failure', array(), "NNGenieMaintenanceBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addError($message);
                        return $this->render('NNGenieMaintenanceBundle:Anomalies:form-add-anomalie.html.twig', array('form' => $form->createView(), 'questions' => $questions, 'operations' => $operations, 'tests' => $tests));
                    }
                } else {
                    $message = $this->get('translator')->trans('Anomalie.exist_already', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    return $this->render('NNGenieMaintenanceBundle:Anomalies:form-add-anomalie.html.twig', array('form' => $form->createView(), 'questions' => $questions, 'operations' => $operations, 'tests' => $tests));
                }
            }
            return $this->render('NNGenieMaintenanceBundle:Anomalies:form-add-anomalie.html.twig', array('form' => $form->createView(), 'questions' => $questions, 'operations' => $operations, 'tests' => $tests));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_anomalies'));
        }
    }

    /**
     * Finds and displays a Anomalie entity.
     *
     * @Route("/show-anomalie/{id}", name="post_admin_show")
     * @Method({"GET"})
     */
    public function showAction(Anomalie $anomalie) {
        $deleteForm = $this->createDeleteForm($anomalie);

        return $this->render('anomalie/show.html.twig', array(
                    'anomalie' => $anomalie,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Anomalie entity.
     *
     * @Route("/edit-anomalie/{id}")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function editAction(Request $request, Anomalie $anomalie) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $question = new Question();
        $editForm = $this->createForm(new AnomalieType(), $anomalie);
        $editForm->handleRequest($request);
        $repositoryAnomalie = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Anomalie");
        $repositoryQuestion = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Question");
        $repositoryOperation = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Operation");
        $repositoryTest = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Test");
        $originalQuestions = new \Doctrine\Common\Collections\ArrayCollection();
        $originalOperations = new \Doctrine\Common\Collections\ArrayCollection();
        $originalTests= new \Doctrine\Common\Collections\ArrayCollection();
        $othersQuestions = new \Doctrine\Common\Collections\ArrayCollection();
        $othersOperations = new \Doctrine\Common\Collections\ArrayCollection();
        $othersTests = new \Doctrine\Common\Collections\ArrayCollection();
        $questions = $repositoryQuestion->findBy(array("statut" => 1));
        $operations = $repositoryOperation->findBy(array("statut" => 1));
        $tests = $repositoryTest->findBy(array("statut" => 1));
        
        foreach ($questions as $question) {
            if (!$anomalie->getQuestions()->contains($question)) {
                $othersQuestions->add($question);
            }
        }
        
        foreach ($operations as $operation) {
            if (!$anomalie->getOperations()->contains($operation)) {
                $othersOperations->add($operation);
            }
        }
        foreach ($tests as $test) {
            if (!$anomalie->getTests()->contains($test)) {
                $othersTests->add($test);
            }
        }
        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    $idquestions = $request->request->get("idquestions");
                    $idoperations = $request->request->get("idoperations");
                    $idtests = $request->request->get("idtests");
                    
                    foreach ($originalQuestions as $question) {
                        if (false === $anomalie->getQuestions()->contains($question)) {
                            // remove the anomalie from the piece
                            $question->getAnomalies()->removeElement($anomalie);
                            $repositoryQuestion->updateQuestion($question);
                        }
                    }

                    //add others exists questions to a anomalie
                    if ($idquestions && is_array($idquestions) && !empty($idquestions)) {
                        foreach ($idquestions as $idquestion) {
                            $idquestion = (int) $idquestion;
                            $question = $repositoryQuestion->find($idquestion);
                            if (false === $anomalie->getQuestions()->contains($question)) {
                                $anomalie->getQuestions()->add($question);
                                $question->getAnomalies()->add($anomalie);
                                $repositoryQuestion->updateQuestion($question);
                            }
                        }
                    }
                    
                    foreach ($originalOperations as $operation) {
                        if (false === $anomalie->getOperations()->contains($operation)) {
                            // remove the anomalie from the piece
                            $operation->getAnomalies()->removeElement($anomalie);
                            $repositoryOperation->updateOperation($operation);
                        }
                    }

                    //add others exists operations to a anomalie
                    if ($idoperations && is_array($idoperations) && !empty($idoperations)) {
                        foreach ($idoperations as $idoperation) {
                            $idoperation = (int) $idoperation;
                            $operation = $repositoryOperation->find($idoperation);
                            if (false === $anomalie->getOperations()->contains($operation)) {
                                $anomalie->getOperations()->add($operation);
                                $operation->getAnomalies()->add($anomalie);
                                $repositoryOperation->updateOperation($operation);
                            }
                        }
                    }
                    
                    foreach ($originalTests as $test) {
                        if (false === $anomalie->getTests()->contains($test)) {
                            // remove the anomalie from the piece
                            $test->getAnomalies()->removeElement($anomalie);
                            $repositoryTest->updateTest($test);
                        }
                    }

                    //add others exists tests to a anomalie
                    if ($idtests && is_array($idtests) && !empty($idtests)) {
                        foreach ($idtests as $idtest) {
                            $idtest = (int) $idtest;
                            $test = $repositoryTest->find($idtest);
                            if (false === $anomalie->getTests()->contains($test)) {
                                $anomalie->getTests()->add($test);
                                $operation->getAnomalies()->add($anomalie);
                                $repositoryTest->updateTest($test);
                            }
                        }
                    }

                    $repositoryAnomalie->updateAnomalie($anomalie);
                    $message = $this->get('translator')->trans('Anomalie.updated_success', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                    return $this->redirect($this->generateUrl('nn_genie_maintenance_anomalies'));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Anomalie.updated_failure', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    return $this->render('NNGenieMaintenanceBundle:Anomalies:form-update-anomalie.html.twig', array('form' => $editForm->createView(), 'anomalie' => $anomalie, 'questions' => $othersQuestions, 'operations' => $othersOperations, 'tests' => $othersTests));
                }
            }
            foreach ($anomalie->getQuestions() as $question) {
                $originalQuestions->add($question);
            }
            foreach ($anomalie->getOperations() as $operation) {
                $othersOperations->add($operation);
            }
            foreach ($anomalie->getTests() as $test) {
                $originalTests->add($test);
            }
            return $this->render('NNGenieMaintenanceBundle:Anomalies:form-update-anomalie.html.twig', array('form' => $editForm->createView(), 'anomalie' => $anomalie, 'questions' => $othersQuestions, 'operations' => $othersOperations, 'tests' => $othersTests));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_anomalies'));
        }
    }

    /**
     * Deletes a Anomalie entity.
     *
     * @Route("/delete-anomalie/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function deleteAction(Anomalie $anomalie) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $request = $this->get("request");
        $repositoryAnomalie = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Anomalie");
        $repositoryQuestion = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Question");
        $repositoryOperation = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Operation");
        $repositoryTest = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Test");
        if ($request->isMethod('GET')) {
            try {
                foreach ($anomalie->getQuestions() as $question) {
                    $question->getAnomalies()->removeElement($anomalie);
                    $repositoryQuestion->updateQuestion($question);
                }
                foreach ($anomalie->getOperations() as $operation) {
                    $operation->getAnomalies()->removeElement($anomalie);
                    $repositoryOperation->updateOperation($operation);
                }
                foreach ($anomalie->getTests() as $test) {
                    $test->getAnomalies()->removeElement($anomalie);
                    $repositoryTest->updateTest($test);
                }
                $repositoryAnomalie->deleteAnomalie($anomalie);
                $message = $this->get('translator')->trans('Anomalie.deleted_success', array(), "NNGenieMaintenanceBundle");
                $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                return $this->redirect($this->generateUrl('nn_genie_maintenance_anomalies'));
            } catch (Exception $ex) {
                $message = $this->get('translator')->trans('Anomalie.updated_failure', array(), "NNGenieMaintenanceBundle");
                $this->get('ras_flash_alert.alert_reporter')->addError($message);
                return $this->redirect($this->generateUrl('nn_genie_maintenance_anomalies'));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_anomalies'));
        }
    }

}
