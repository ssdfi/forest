<?php

namespace AppBundle\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Expedientes;
use AppBundle\Form\ExpedientesType;
use Doctrine\ORM\Query;

class ExpedientesController extends Controller
{
    /**
     * Lists all Expedientes entities.
     *
     * @Route("/", name="list_expedientes")
     * @Method("GET")
     */
    public function listExpedientes(Request $request)
    {
      $em    = $this->get('doctrine.orm.entity_manager');
      $dql   = "SELECT a FROM AppBundle:Expedientes a";
      $query = $em->createQuery($dql);
      $paginator = $this->get('knp_paginator');
      $expedientes = $paginator->paginate(
              $query,
              $request->query->getInt('page', 1),
              15,
              array('defaultSortFieldName' => 'a.id', 'defaultSortDirection' => 'desc')
          );
      return $this->render('expedientes/list.html.twig',array('expedientes' => $expedientes));
    }

    /**
     * Creates a new Expedientes entity.
     *
     * @Route("/expedientes/new", name="expedientes_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $expediente = new Expedientes();
        $form = $this->createForm('AppBundle\Form\ExpedientesType', $expediente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($expediente);
            $em->flush();

            return $this->redirectToRoute('expedientes_show', array('id' => $expediente->getId()));
        }

        return $this->render('expedientes/new.html.twig', array(
            'expediente' => $expediente,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Expedientes entity.
     *
     * @Route("/expedientes/{id}", name="expedientes_show")
     * @Method("GET")
     */
    public function showAction(Expedientes $expediente, $id)
    {
      $em = $this->getDoctrine()->getManager();
      $dql_m   = "SELECT m
                FROM AppBundle:Plantaciones p
                JOIN AppBundle:ActividadesPlantaciones ap WITH p.id=ap.plantacion
                JOIN AppBundle:Actividades a WITH a.id=ap.actividad
                JOIN AppBundle:Movimientos m WITH m.id=a.movimiento
                JOIN AppBundle:Expedientes e WITH e.id=m.expediente
                WHERE p.id=:id";
      $movimientos=$em->createQuery($dql_m)->setParameters(array('id' => $id))->getResult(Query::HYDRATE_OBJECT);
      $deleteForm = $this->createDeleteForm($expediente);

      return $this->render('expedientes/show.html.twig', array(
          'expediente' => $expediente,
          'movimientos' => $movimientos,
          'delete_form' => $deleteForm->createView(),
      ));
    }

    /**
     * Displays a form to edit an existing Expedientes entity.
     *
     * @Route("/expedientes/{id}/edit", name="expedientes_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Expedientes $expediente)
    {
        $deleteForm = $this->createDeleteForm($expediente);
        $editForm = $this->createForm('AppBundle\Form\ExpedientesType', $expediente);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($expediente);
            $em->flush();

            return $this->redirectToRoute('expedientes_edit', array('id' => $expediente->getId()));
        }

        return $this->render('expedientes/edit.html.twig', array(
            'expediente' => $expediente,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Expedientes entity.
     *
     * @Route("/{id}", name="expedientes_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Expedientes $expediente)
    {
        $form = $this->createDeleteForm($expediente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($expediente);
            $em->flush();
        }

        return $this->redirectToRoute('expedientes_index');
    }

    /**
     * Creates a form to delete a Expedientes entity.
     *
     * @param Expedientes $expediente The Expedientes entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Expedientes $expediente)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('expedientes_delete', array('id' => $expediente->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
