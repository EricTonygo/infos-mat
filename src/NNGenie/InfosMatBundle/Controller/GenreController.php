<?php

namespace NNGenie\InfosMatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\InfosMatBundle\Entity\Genre;
use NNGenie\InfosMatBundle\Form\GenreType;

class GenreController extends Controller{
    
    /**
     * @Route("/genres")
     * @Template()
     * @Method({"GET"})
     * @param Request $request
     */
    public function genresAction() {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryGenre = $em->getRepository("NNGenieInfosMatBundle:Genre");
        $genre = new Genre();
        $form = $this->createForm(new GenreType(), $genre);
        $display_tab = 1;
        //selectionne les seuls genres actifs
        $genres = $repositoryGenre->findBy(array("statut" => 1));

        return $this->render('NNGenieInfosMatBundle:Genres:genres.html.twig', array('genres' => $genres, 'form' => $form->createView(), "display_tab" => $display_tab));
    }

    /**
     * Creates a new Genre entity.
     *
     * @Route("/new-genre")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function newAction(Request $request) {
        $genre = new Genre();
        $genreUnique = new Genre();
        $form = $this->createForm(new GenreType(), $genre);
        $form->handleRequest($request);
        $repositoryGenre = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Genre");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $genreUnique = $repositoryGenre->findBy(array("nom" => $genre->getNom()));
                if ($genreUnique != null) {
                    try {
                        $repositoryGenre->saveGenre($genre);
                        $message = $this->get('translator')->trans('Genre.created_success', array(), "NNGenieInfosMatBundle");
                        $request->getSession()->getFlashBag()->add('message_success', $message);
                        return $this->redirect($this->generateUrl('nn_genie_infos_mat_genres'));
                    } catch (Exception $ex) {
                        $message = $this->get('translator')->trans('Genre.created_failure', array(), "NNGenieInfosMatBundle");
                        $request->getSession()->getFlashBag()->add('message_faillure', $message);
                        return $this->render('NNGenieInfosMatBundle:Genres:form-add-genre.html.twig', array('form' => $form->createView()));
                    }
                } else {
                    $message = $this->get('translator')->trans('Genre.exist_already', array(), "NNGenieInfosMatBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    return $this->render('NNGenieInfosMatBundle:Genres:form-add-genre.html.twig', array('form' => $form->createView()));
                }
            }
            return $this->render('NNGenieInfosMatBundle:Genres:form-add-genre.html.twig', array('form' => $form->createView()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_genres'));
        }
    }

    /**
     * Finds and displays a Genre entity.
     *
     * @Route("/show-genre/{id}", name="post_admin_show")
     * @Method("GET")
     */
    public function showAction(Genre $genre) {
        $deleteForm = $this->createDeleteForm($genre);

        return $this->render('genre/show.html.twig', array(
                    'genre' => $genre,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Genre entity.
     *
     * @Route("/update-genre/{id}")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function editAction(Request $request, Genre $genre) {
        // $deleteForm = $this->createDeleteForm($genre);
        $editForm = $this->createForm(new GenreType(), $genre);
        $editForm->handleRequest($request);
        $repositoryGenre = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Genre");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    $repositoryGenre->updateGenre($genre);
                    $message = $this->get('translator')->trans('Genre.updated_success', array(), "NNGenieInfosMatBundle");
                    $request->getSession()->getFlashBag()->add('message_success', $message);
                    return $this->redirect($this->generateUrl('nn_genie_infos_mat_genres'));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Genre.updated_failure', array(), "NNGenieInfosMatBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    return $this->render('NNGenieInfosMatBundle:Genres:form-update-genre.html.twig', array('form' => $editForm->createView(), 'idgenre' => $genre->getId()));
                }
            }
            return $this->render('NNGenieInfosMatBundle:Genres:form-update-genre.html.twig', array('form' => $editForm->createView(), 'idgenre' => $genre->getId()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_genres'));
        }
    }

    /**
     * Deletes a Genre entity.
     *
     * @Route("/delete-genre/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function deleteAction(Genre $genre) {
        $request = $this->get("request");
        $repositoryGenre = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Genre");
        if ($request->isMethod('GET')) {
            try {
                $repositoryGenre->deleteGenre($genre);
                $message = $message = $this->get('translator')->trans('Genre.deleted_success', array(), "NNGenieInfosMatBundle");
                $request->getSession()->getFlashBag()->add('message_success', $message);
                    return $this->redirect($this->generateUrl('nn_genie_infos_mat_genres'));
            } catch (Exception $ex) {
                $message = $message = $this->get('translator')->trans('Genre.deleted_failure', array(), "NNGenieInfosMatBundle");
                $request->getSession()->getFlashBag()->add('message_faillure', $message);
                return $this->redirect($this->generateUrl('nn_genie_infos_mat_genres'));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_genres'));
        }
    }

    /**
     * Creates a form to delete a Genre entity.
     *
     * @param Genre $genre The Genre entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Genre $genre) {
        return $this->createFormBuilder
                        ->setAction($this->generateUrl('post_admin_delete', array('id' => $genre->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }
    
    /**
     * Creates a form to add a Genre entity.
     *
     * @param Genre $genre The Genre entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createAddForm() {
        return $this->createFormBuilder
                        ->setAction($this->generateUrl('nn_genie_infos_mat_genre_add'))
                        ->setMethod('POST')
                        ->getForm()
        ;
    }
}
