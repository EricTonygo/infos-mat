<?php

namespace NNGenie\MaintenanceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\MaintenanceBundle\Entity\Test;
use NNGenie\MaintenanceBundle\Entity\Resultat;
use NNGenie\MaintenanceBundle\Form\TestType;

/**
 * Test controller.
 *
 */
class TestController extends Controller {

    /**
     * @Route("/tests")
     * @Template()
     */
    public function testsAction() {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryTest = $em->getRepository("NNGenieMaintenanceBundle:Test");
        $test = new Test();
        $form = $this->createForm(new TestType(), $test);
        //selectionne les seuls tests materiel actifs
        $tests = $repositoryTest->findBy(array("statut" => 1));

        return $this->render('NNGenieMaintenanceBundle:Tests:tests.html.twig', array('tests' => $tests, 'form' => $form->createView()));
    }

    /**
     * @Route("/tests-user")
     * @Template()
     */
    public function testsuserAction() {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryTest = $em->getRepository("NNGenieMaintenanceBundle:Test");
        $test = new Test();
        $form = $this->createForm(new TestType(), $test);
        $display_tab = 1;
        //selectionne les seuls tests materiel actifs
        $tests = $repositoryTest->findBy(array("statut" => 1));

        return $this->render('NNGenieMaintenanceBundle:FrontEnd:test.html.twig', array('tests' => $tests, 'form' => $form->createView(), "display_tab" => $display_tab));
    }

    /**
     * Creates a new Test entity.
     *
     * @Route("/new-test")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function newAction(Request $request) {
        $test = new Test();
        $resultat = new Resultat();
        $form = $this->createForm(new TestType(), $test);
        $form->handleRequest($request);
        $repositoryTest = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Test");
        $repositoryResultat = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Resultat");
        $resultats = $repositoryResultat->findBy(array("statut" => 1));
        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $testUnique = $repositoryTest->findBy(array("intitule" => $test->getIntitule(), "statut" => 1));
                if ($testUnique == null) {
                    try {
                        foreach ($test->getResultats() as $resultat) {
                            $resultat->setTest($test);
                        }
                        $repositoryTest->saveTest($test);
                        $message = $this->get('translator')->trans('Test.created_success', array(), "NNGenieMaintenanceBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                        $test = new Test();
                        $form = $this->createForm(new TestType(), $test);
                        return $this->render('NNGenieMaintenanceBundle:Tests:form-add-test.html.twig', array('form' => $form->createView(), 'resultats' => $resultats));
                    } catch (Exception $ex) {
                        $message = $this->get('translator')->trans('Test.created_failure', array(), "NNGenieMaintenanceBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addError($message);
                        return $this->render('NNGenieMaintenanceBundle:Tests:form-add-test.html.twig', array('form' => $form->createView(), 'resultats' => $resultats));
                    }
                } else {
                    $message = $this->get('translator')->trans('Test.exist_already', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    return $this->render('NNGenieMaintenanceBundle:Tests:form-add-test.html.twig', array('form' => $form->createView(), 'resultats' => $resultats));
                }
            }
            return $this->render('NNGenieMaintenanceBundle:Tests:form-add-test.html.twig', array('form' => $form->createView(), 'resultats' => $resultats));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_tests'));
        }
    }

    /**
     * Finds and displays a Test entity.
     *
     * @Route("/show-test/{id}", name="post_admin_show")
     * @Method({"GET"})
     */
    public function showAction(Test $test) {
        $deleteForm = $this->createDeleteForm($test);

        return $this->render('test/show.html.twig', array(
                    'test' => $test,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Test entity.
     *
     * @Route("/edit-test/{id}")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function editAction(Request $request, Test $test) {
        $resultat = new Resultat();
        $editForm = $this->createForm(new TestType(), $test);
        $editForm->handleRequest($request);
        $repositoryTest = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Test");
        $repositoryResultat = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Resultat");
        $othersProducts = new \Doctrine\Common\Collections\ArrayCollection();
        $originalResultats = new \Doctrine\Common\Collections\ArrayCollection();
        $resultats = $repositoryResultat->findBy(array("statut" => 1));
        foreach ($resultats as $resultat) {
            if (!$test->getResultats()->contains($resultat)) {
                $othersProducts->add($resultat);
            }
        }
        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    // remove the relationship between the tag and the Task
                    foreach ($originalResultats as $resultat) {
                        if (false === $test->getResultats()->contains($resultat)) {
                            // remove the test from the resultat
                            //$resultat->getTests()->removeElement($test);
                            // if it was a many-to-one relationship, remove the relationship like this

                            $repositoryResultat->deleteResultat($resultat);

                            // if you wanted to delete the Resultat entirely, you can also do that
                            // $em->remove($resultat);
                        }
                    }
                    foreach ($test->getResultats() as $resultat) {
                        $resultat->setTest($test);
                    }
                    $repositoryTest->updateTest($test);
                    $message = $this->get('translator')->trans('Test.updated_success', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                    return $this->redirect($this->generateUrl('nn_genie_maintenance_tests'));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Test.updated_failure', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    return $this->render('NNGenieMaintenanceBundle:Tests:form-update-test.html.twig', array('form' => $editForm->createView(), 'idtest' => $test->getId(), 'resultats' => $othersProducts));
                }
            }
            foreach ($test->getResultats() as $resultat) {
                $originalResultats->add($resultat);
            }
            return $this->render('NNGenieMaintenanceBundle:Tests:form-update-test.html.twig', array('form' => $editForm->createView(), 'idtest' => $test->getId(), 'resultats' => $othersProducts));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_tests'));
        }
    }

    /**
     * Deletes a Test entity.
     *
     * @Route("/delete-test/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function deleteAction(Test $test) {
        $request = $this->get("request");
        $repositoryTest = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Test");
        $repositoryResultat = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Resultat");
        $resultat = new Resultat();
        if ($request->isMethod('GET')) {
            try {
                foreach ($test->getResultats() as $resultat) {
                    $repositoryResultat->deleteResultat($resultat);
                }
                $repositoryTest->deleteTest($test);
                $message = $this->get('translator')->trans('Test.deleted_success', array(), "NNGenieMaintenanceBundle");
                $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                return $this->redirect($this->generateUrl('nn_genie_maintenance_tests'));
            } catch (Exception $ex) {
                $message = $this->get('translator')->trans('Test.updated_failure', array(), "NNGenieMaintenanceBundle");
                $this->get('ras_flash_alert.alert_reporter')->addError($message);
                return $this->redirect($this->generateUrl('nn_genie_maintenance_tests'));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_tests'));
        }
    }

}
