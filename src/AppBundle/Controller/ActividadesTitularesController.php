<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ActividadesTitulares;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Actividadestitulare controller.
 *
 *
 */
class ActividadesTitularesController extends Controller
{
    /**
    * Creates a new actividadesTitulare entity.
    *
    * @Route("/expedientes/{idExp}/movimientos/{idMov}/actividades/{idAct}/actividadesTitular/new", name="newActividadesTitulares")
    * @Method({"GET", "POST"})
    */

    public function newAction(Request $request)
    {
      $actividadesTitulare = new Actividadestitulare();
      $form = $this->createForm('AppBundle\Form\ActividadesTitularesType', $actividadesTitulare);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($actividadesTitulare);
        $em->flush($actividadesTitulare);

        return $this->redirectToRoute('actividadestitulares_show', array('id' => $actividadesTitulare->getId()));
      }

      return $this->render('actividadestitulares/new.html.twig', array(
        'actividadesTitulare' => $actividadesTitulare,
        'form' => $form->createView(),
      ));
    }
    /**
     * Lists all actividadesTitulare entities.
     *
     * @Route("/expedientes/{idExp}/movimientos/{idMov}/actividades/{idAct}/actividadesTitular/", name="actividadestitulares_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $actividadesTitulares = $em->getRepository('AppBundle:ActividadesTitulares')->findAll();

        return $this->render('actividadestitulares/index.html.twig', array(
            'actividadesTitulares' => $actividadesTitulares,
        ));
    }


    /**
     * Finds and displays a actividadesTitulare entity.
     *
     * @Route("/expedientes/{idExp}/movimientos/{idMov}/actividades/{idAct}/actividadesTitular/{id}", name="actividadestitulares_show")
     * @Method("GET")
     */
    public function showAction(ActividadesTitulares $actividadesTitulare)
    {
        $deleteForm = $this->createDeleteForm($actividadesTitulare);

        return $this->render('actividadestitulares/show.html.twig', array(
            'actividadesTitulare' => $actividadesTitulare,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing actividadesTitulare entity.
     *
     * @Route("/expedientes/{idExp}/movimientos/{idMov}/actividades/{idAct}/actividadesTitular/{id}/edit", name="actividadestitulares_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ActividadesTitulares $actividadesTitulare)
    {
        $deleteForm = $this->createDeleteForm($actividadesTitulare);
        $editForm = $this->createForm('AppBundle\Form\ActividadesTitularesType', $actividadesTitulare);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('actividadestitulares_edit', array('id' => $actividadesTitulare->getId()));
        }

        return $this->render('actividadestitulares/edit.html.twig', array(
            'actividadesTitulare' => $actividadesTitulare,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a actividadesTitulare entity.
     *
     * @Route("/expedientes/{idExp}/movimientos/{idMov}/actividades/{idAct}/actividadesTitular/{id}", name="actividadestitulares_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ActividadesTitulares $actividadesTitulare)
    {
        $form = $this->createDeleteForm($actividadesTitulare);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($actividadesTitulare);
            $em->flush($actividadesTitulare);
        }

        return $this->redirectToRoute('actividadestitulares_index');
    }

    /**
     * Creates a form to delete a actividadesTitulare entity.
     *
     * @param ActividadesTitulares $actividadesTitulare The actividadesTitulare entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ActividadesTitulares $actividadesTitulare)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('actividadestitulares_delete', array('id' => $actividadesTitulare->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
