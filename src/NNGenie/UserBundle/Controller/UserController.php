<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UtilisateurController
 *
 * @author Quentin
 * 
 * Il s'agit de quelques fonction qui ne sont pas gerées par fosuserbundle
 */

namespace NNGenie\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use NNGenie\UserBundle\Entity\User;
use Symfony\Bundle\SwiftmailerBundle;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UserController extends Controller {

    /**
     * @Route("/utilisateurs", name="gestion_projet_users_all")
     * @Method({"GET"})
     */
    public function getAllUsersAction() {
		if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }

        $userManager = $this->container->get('fos_user.user_manager');

        try {
            $users = $userManager->findUsers();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $this->render("NNGenieUserBundle:Users:users.html.twig", array('users' => $users));
    }
    
    /**
     * @Route("/utilisateurs", name="gestion_projet_users_all")
     * @Method({"GET"})
     */
    public function getAllUsersuserAction() {
		if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }

        $userManager = $this->container->get('fos_user.user_manager');

        try {
            $users = $userManager->findUsers();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $this->render("NNGenieInfosMatBundle:FrontEnd:users.html.twig", array('users' => $users));
    }

    /**
	 * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Route("/blockutilisateur/{id}", name="gestion_projet_user_active")
     * @Method({"GET"})
     */
    public function lockUserAction(NNGenie\UserBundle\Entity\User $user) {

        $userManager = $this->container->get('fos_user.user_manager');
        if($user->isEnabled() && !$user->isLocked()){
            $user->setLocked(true);
            $user->setEnabled(false);
        }else{
            $user->setLocked(false);
            $user->setEnabled(true);
        }
        $userManager->updateUser($user);
        return $this->redirect($this->generateUrl('gestion_projet_users_all'));
    }

    public function getOneUserAction($email) {

        $userManager = $container->get('fos_user.user_manager');

        try {
            $user = $userManager->findUserByEmail($email);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
