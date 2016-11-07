<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Movimientos;
use AppBundle\Form\MovimientosType;

/**
 * Movimientos controller.
 *
 * @Route("expedientes/{id}/movimientos")
 */
class MovimientosController extends Controller
{
    /**
     * Lists all Movimientos entities.
     *
     * @Route("movimientos/", name="movimientos_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $movimientos = $em->getRepository('AppBundle:Movimientos')->findAll();

        return $this->render('movimientos/index.html.twig', array(
            'movimientos' => $movimientos,
        ));
    }

    /**
     * Creates a new Movimientos entity.
     *
     * @Route("/movimientos/new", name="movimientos_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $movimiento = new Movimientos();
        $form = $this->createForm('AppBundle\Form\MovimientosType', $movimiento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($movimiento);
            $em->flush();

            return $this->redirectToRoute('movimientos_show', array('id' => $movimiento->getId()));
        }

        return $this->render('movimientos/new.html.twig', array(
            'movimiento' => $movimiento,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Movimientos entity.
     *
     * @Route("/movimientos/{id_mov}", name="movimientos_show")
     * @Method("GET")
     */
    public function showAction(Movimientos $movimiento)
    {
        $deleteForm = $this->createDeleteForm($movimiento);

        return $this->render('movimientos/show.html.twig', array(
            'movimiento' => $movimiento,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Movimientos entity.
     *
     * @Route("/movimientos/{id_mov}/edit", name="movimientos_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Movimientos $movimiento)
    {
        $deleteForm = $this->createDeleteForm($movimiento);
        $editForm = $this->createForm('AppBundle\Form\MovimientosType', $movimiento);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($movimiento);
            $em->flush();

            return $this->redirectToRoute('movimientos_edit', array('id' => $movimiento->getId()));
        }

        return $this->render('movimientos/edit.html.twig', array(
            'movimiento' => $movimiento,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Movimientos entity.
     *
     * @Route("/movimientos/{id_mov}", name="movimientos_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Movimientos $movimiento)
    {
        $form = $this->createDeleteForm($movimiento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($movimiento);
            $em->flush();
        }

        return $this->redirectToRoute('movimientos_index');
    }

    /**
     * Creates a form to delete a Movimientos entity.
     *
     * @param Movimientos $movimiento The Movimientos entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Movimientos $movimiento)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('movimientos_delete', array('id' => $movimiento->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
