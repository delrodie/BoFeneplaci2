<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Dren;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Dren controller.
 *
 * @Route("admin/dren")
 */
class DrenController extends Controller
{
    /**
     * Lists all dren entities.
     *
     * @Route("/", name="admin_dren_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $drens = $em->getRepository('AppBundle:Dren')->findAll();

        return $this->render('dren/index.html.twig', array(
            'drens' => $drens,
        ));
    }

    /**
     * Creates a new dren entity.
     *
     * @Route("/new", name="admin_dren_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $dren = new Dren();
        $form = $this->createForm('AppBundle\Form\DrenType', $dren);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dren);
            $em->flush();

            return $this->redirectToRoute('admin_dren_index');
        }

        return $this->render('dren/new.html.twig', array(
            'dren' => $dren,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a dren entity.
     *
     * @Route("/{id}", name="admin_dren_show")
     * @Method("GET")
     */
    public function showAction(Dren $dren)
    {
        $deleteForm = $this->createDeleteForm($dren);

        return $this->render('dren/show.html.twig', array(
            'dren' => $dren,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing dren entity.
     *
     * @Route("/{slug}/edit", name="admin_dren_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Dren $dren)
    {
        $deleteForm = $this->createDeleteForm($dren);
        $editForm = $this->createForm('AppBundle\Form\DrenType', $dren);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_dren_index');
        }

        return $this->render('dren/edit.html.twig', array(
            'dren' => $dren,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a dren entity.
     *
     * @Route("/{id}", name="admin_dren_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Dren $dren)
    {
        $form = $this->createDeleteForm($dren);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($dren);
            $em->flush();
        }

        return $this->redirectToRoute('admin_dren_index');
    }

    /**
     * Creates a form to delete a dren entity.
     *
     * @param Dren $dren The dren entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Dren $dren)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_dren_delete', array('id' => $dren->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
