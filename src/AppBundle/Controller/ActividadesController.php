<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Actividades;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Actividade controller.
 *
 * @Route("actividades")
 */
class ActividadesController extends Controller
{
    /**
     * Lists all actividade entities.
     *
     * @Route("/", name="actividades_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $actividades = $em->getRepository('AppBundle:Actividades')->findAll();

        return $this->render('actividades/index.html.twig', array(
            'actividades' => $actividades,
        ));
    }

    /**
     * Creates a new actividade entity.
     *
     * @Route("/new", name="actividades_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $actividade = new Actividade();
        $form = $this->createForm('AppBundle\Form\ActividadesType', $actividade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($actividade);
            $em->flush($actividade);

            return $this->redirectToRoute('actividades_show', array('id' => $actividade->getId()));
        }

        return $this->render('actividades/new.html.twig', array(
            'actividade' => $actividade,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a actividade entity.
     *
     * @Route("/{id}", name="actividades_show")
     * @Method("GET")
     */
    public function showAction(Actividades $actividade)
    {
        $deleteForm = $this->createDeleteForm($actividade);

        return $this->render('actividades/show.html.twig', array(
            'actividade' => $actividade,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing actividade entity.
     *
     * @Route("/{id}/edit", name="actividades_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Actividades $actividade)
    {
        $deleteForm = $this->createDeleteForm($actividade);
        $editForm = $this->createForm('AppBundle\Form\ActividadesType', $actividade);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('actividades_edit', array('id' => $actividade->getId()));
        }

        return $this->render('actividades/edit.html.twig', array(
            'actividade' => $actividade,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a actividade entity.
     *
     * @Route("/{id}", name="actividades_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Actividades $actividade)
    {
        $form = $this->createDeleteForm($actividade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($actividade);
            $em->flush($actividade);
        }

        return $this->redirectToRoute('actividades_index');
    }

    /**
     * Creates a form to delete a actividade entity.
     *
     * @param Actividades $actividade The actividade entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Actividades $actividade)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('actividades_delete', array('id' => $actividade->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
