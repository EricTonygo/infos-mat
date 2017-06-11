<?php

namespace NNGenie\InfosMatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of ImportDatabaseController
 *
 * @author Eric TONYE
 */
class ImportDatabaseController extends Controller {

    //put your code here
    /**
     * @Route("/import-materiels-to-database")
     * @Template()
     */
    public function importMaterielsToDatabaseAction(Request $request) {
//        foreach ($request->files as $uploadedFile) {
//            $name = 'materiels'.$uploadedFile->guessExtension();
//            $file = $uploadedFile->move($this->getUploadRootDir(), $name);
//        }
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } 
        if ($request->isMethod("POST")) {
            $file = $request->files->get('materiels_xlsx_file');

            if ($file) {
                //$original_filename = $file->getClientOriginalName();
                $name = 'materiels.' . $file->guessExtension();
                $file = $file->move($this->getUploadRootDir(), $name);
                $result = "tmp";
                if(file_exists($this->getUploadRootDir() ."/". $name)){
                    $result = $this->get('excel_service')->importMaterielsToDatabase($this->getUploadRootDir() ."/". $name);
                }
                $message = $this->get('translator')->trans('Materiels.imported_success', array(), "NNGenieInfosMatBundle");
                $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                return $this->redirect($this->generateUrl('nn_genie_infos_mat_materiels'));
            }else{
                $message = $this->get('translator')->trans('Materiels.imported_failure', array(), "NNGenieInfosMatBundle");
                $this->get('ras_flash_alert.alert_reporter')->addError($message);
                return $this->render('NNGenieInfosMatBundle:importDatabase:form-import-database.html.twig');
            }
        } elseif ($request->isMethod("GET")) {
            return $this->render('NNGenieInfosMatBundle:importDatabase:form-import-database.html.twig');
        }
    }

    private function getUploadRootDir() {
        return '/../../../../web/uploads/importFiles';
    }

}
