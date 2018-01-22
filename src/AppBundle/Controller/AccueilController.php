<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Accueil;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Accueil controller.
 *
 * @Route("admin/accueil")
 */
class AccueilController extends Controller
{
    /**
     * Lists all accueil entities.
     *
     * @Route("/", name="admin_accueil_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $accueils = $em->getRepository('AppBundle:Accueil')->findAll();

        return $this->render('accueil/index.html.twig', array(
            'accueils' => $accueils,
        ));
    }

    /**
     * Creates a new accueil entity.
     *
     * @Route("/new", name="admin_accueil_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $accueil = new Accueil();
        $form = $this->createForm('AppBundle\Form\AccueilType', $accueil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($accueil);
            $em->flush();

            return $this->redirectToRoute('admin_accueil_show', array('slug' => $accueil->getSlug()));
        }

        return $this->render('accueil/new.html.twig', array(
            'accueil' => $accueil,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a accueil entity.
     *
     * @Route("/{slug}", name="admin_accueil_show")
     * @Method("GET")
     */
    public function showAction(Accueil $accueil)
    {
        $deleteForm = $this->createDeleteForm($accueil);

        return $this->render('accueil/show.html.twig', array(
            'accueil' => $accueil,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing accueil entity.
     *
     * @Route("/{slug}/edit", name="admin_accueil_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Accueil $accueil)
    {
        $deleteForm = $this->createDeleteForm($accueil);
        $editForm = $this->createForm('AppBundle\Form\AccueilType', $accueil);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_accueil_show', array('slug' => $accueil->getSlug()));
        }

        return $this->render('accueil/edit.html.twig', array(
            'accueil' => $accueil,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a accueil entity.
     *
     * @Route("/{id}", name="admin_accueil_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Accueil $accueil)
    {
        $form = $this->createDeleteForm($accueil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($accueil);
            $em->flush();
        }

        return $this->redirectToRoute('admin_accueil_index');
    }

    /**
     * Creates a form to delete a accueil entity.
     *
     * @param Accueil $accueil The accueil entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Accueil $accueil)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_accueil_delete', array('id' => $accueil->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
