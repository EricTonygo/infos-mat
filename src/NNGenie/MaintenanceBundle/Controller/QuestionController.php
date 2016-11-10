<?php

namespace NNGenie\MaintenanceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\MaintenanceBundle\Entity\Question;
use NNGenie\MaintenanceBundle\Form\QuestionType;

/**
 * Question controller.
 *
 */
class QuestionController extends Controller {

    /**
     * @Route("/questions")
     * @Template()
     */
    public function questionsAction() {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryQuestion = $em->getRepository("NNGenieMaintenanceBundle:Question");
        $question = new Question();
        $form = $this->createForm(new QuestionType(), $question);
        //selectionne les seuls questions materiel actifs
        $questions = $repositoryQuestion->findBy(array("statut" => 1));

        return $this->render('NNGenieMaintenanceBundle:Questions:questions.html.twig', array('questions' => $questions, 'form' => $form->createView()));
    }

    /**
     * Creates a new Question entity.
     *
     * @Route("/new-question")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function newAction(Request $request) {
        $question = new Question();
        $questionUnique = new Question();
        $form = $this->createForm(new QuestionType(), $question);
        $form->handleRequest($request);
        $repositoryQuestion = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Question");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $questionUnique = $repositoryQuestion->findBy(array("intitule" => $question->getIntitule(), "statut" => 1));
                if ($questionUnique == null) {
                    try {
                        $repositoryQuestion->saveQuestion($question);
                        $message = $this->get('translator')->trans('Question.created_success', array(), "NNGenieMaintenanceBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                        $question = new Question();
                        $form = $this->createForm(new QuestionType(), $question);
                        return $this->render('NNGenieMaintenanceBundle:Questions:form-add-question.html.twig', array('form' => $form->createView()));
                    } catch (Exception $ex) {
                        $message = $this->get('translator')->trans('Question.created_failure', array(), "NNGenieMaintenanceBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addError($message);
                        return $this->render('NNGenieMaintenanceBundle:Questions:form-add-question.html.twig', array('form' => $form->createView()));
                    }
                } else {
                    $message = $this->get('translator')->trans('Question.exist_already', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    return $this->render('NNGenieMaintenanceBundle:Questions:form-add-question.html.twig', array('form' => $form->createView()));
                }
            }
            return $this->render('NNGenieMaintenanceBundle:Questions:form-add-question.html.twig', array('form' => $form->createView()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_questions'));
        }
    }

    /**
     * Finds and displays a Question entity.
     *
     * @Route("/show-question/{id}", name="post_admin_show")
     * @Method({"GET"})
     */
    public function showAction(Question $question) {
        $deleteForm = $this->createDeleteForm($question);

        return $this->render('question/show.html.twig', array(
                    'question' => $question,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Question entity.
     *
     * @Route("/edit-question/{id}")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function editAction(Request $request, Question $question) {
        // $deleteForm = $this->createDeleteForm($question);
        $editForm = $this->createForm(new QuestionType(), $question);
        $editForm->handleRequest($request);
        $repositoryQuestion = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Question");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    $repositoryQuestion->updateQuestion($question);
                    $message = $this->get('translator')->trans('Question.updated_success', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                    return $this->redirect($this->generateUrl('nn_genie_maintenance_questions'));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Question.updated_failure', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    return $this->render('NNGenieMaintenanceBundle:Questions:form-update-question.html.twig', array('form' => $editForm->createView(), 'idquestion' => $question->getId()));
                }
            }
            return $this->render('NNGenieMaintenanceBundle:Questions:form-update-question.html.twig', array('form' => $editForm->createView(), 'idquestion' => $question->getId()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_questions'));
        }
    }

    /**
     * Deletes a Question entity.
     *
     * @Route("/delete-question/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function deleteAction(Question $question) {
        $request = $this->get("request");
        $panne = new \NNGenie\MaintenanceBundle\Entity\Panne();
        $repositoryQuestion = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Question");
        $repositoryPanne = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Panne");
        if ($request->isMethod('GET')) {
            try {
                foreach ($question->getPannes() as $panne){
                    $panne->getQuestions()->removeElement($question);
                    $repositoryPanne->updatePanne($panne);
                }
                $repositoryQuestion->deleteQuestion($question);
                $message = $this->get('translator')->trans('Question.deleted_success', array(), "NNGenieMaintenanceBundle");
               $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                return $this->redirect($this->generateUrl('nn_genie_maintenance_questions'));
            } catch (Exception $ex) {
                $message = $this->get('translator')->trans('Question.updated_failure', array(), "NNGenieMaintenanceBundle");
                $this->get('ras_flash_alert.alert_reporter')->addError($message);
                return $this->redirect($this->generateUrl('nn_genie_maintenance_questions'));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_questions'));
        }
    }

}