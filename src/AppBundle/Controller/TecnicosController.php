<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Tecnicos;
use AppBundle\Form\TecnicosType;

/**
 * Tecnicos controller.
 *
 * @Route("/tecnicos")
 */
class TecnicosController extends Controller
{
    /**
     * Lists all Tecnicos entities.
     *
     * @Route("/", name="tecnicos_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT a FROM AppBundle:Tecnicos a";
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $tecnicos = $paginator->paginate(
                $query,
                $request->query->getInt('page', 1),
                15,
                array('defaultSortFieldName' => 'a.nombre', 'defaultSortDirection' => 'asc')
            );
        return $this->render('tecnicos/index.html.twig',array('tecnicos' => $tecnicos));
        
    }

    /**
     * Creates a new Tecnicos entity.
     *
     * @Route("/new", name="tecnicos_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tecnico = new Tecnicos();
        $form = $this->createForm('AppBundle\Form\TecnicosType', $tecnico);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tecnico);
            $em->flush();

            return $this->redirectToRoute('tecnicos_show', array('id' => $tecnico->getId()));
        }

        return $this->render('tecnicos/new.html.twig', array(
            'tecnico' => $tecnico,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Tecnicos entity.
     *
     * @Route("/{id}", name="tecnicos_show")
     * @Method("GET")
     */
    public function showAction(Tecnicos $tecnico)
    {
        $deleteForm = $this->createDeleteForm($tecnico);

        return $this->render('tecnicos/show.html.twig', array(
            'tecnico' => $tecnico,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Tecnicos entity.
     *
     * @Route("/{id}/edit", name="tecnicos_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Tecnicos $tecnico)
    {
        $deleteForm = $this->createDeleteForm($tecnico);
        $editForm = $this->createForm('AppBundle\Form\TecnicosType', $tecnico);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tecnico);
            $em->flush();

            return $this->redirectToRoute('tecnicos_edit', array('id' => $tecnico->getId()));
        }

        return $this->render('tecnicos/edit.html.twig', array(
            'tecnico' => $tecnico,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Tecnicos entity.
     *
     * @Route("/{id}", name="tecnicos_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Tecnicos $tecnico)
    {
        $form = $this->createDeleteForm($tecnico);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tecnico);
            $em->flush();
        }

        return $this->redirectToRoute('tecnicos_index');
    }

    /**
     * Creates a form to delete a Tecnicos entity.
     *
     * @param Tecnicos $tecnico The Tecnicos entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tecnicos $tecnico)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tecnicos_delete', array('id' => $tecnico->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
