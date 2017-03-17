<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PlantacionesAportes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Plantaciones;
use AppBundle\Form\PlantacionesType;
use CrEOF\Spatial\PHP\Types\Geometry\LineString;
use CrEOF\Spatial\PHP\Types\Geometry\Point;
use CrEOF\Spatial\PHP\Types\Geometry\Polygon;
use CrEOF\Spatial\Tests\Fixtures\PolygonEntity;
use CrEOF\Spatial\Tests\OrmTestCase;

use Doctrine\ORM\Query;
/**
 * Plantacionesaporte controller.
 *
 * @Route("aportes")
 */
class PlantacionesAportesController extends Controller
{
    /**
     * Lists all plantacionesAporte entities.
     *
     * @Route("/", name="plantacionesaportes_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
      $em    = $this->get('doctrine.orm.entity_manager');
      $dql   = "SELECT a FROM AppBundle:PlantacionesAportes a";
      //, st_area(a.geom)/10000
      $query = $em->createQuery($dql);
      //var_dump($query);
      $paginator = $this->get('knp_paginator');
      $plantaciones = $paginator->paginate(
              $query,
              $request->query->getInt('page', 1),
              15,
              array('defaultSortFieldName' => 'a.id', 'defaultSortDirection' => 'asc')
          );

      return $this->render('plantacionesaportes/index.html.twig',array('plantaciones' => $plantaciones));
    }

    /**
     * Creates a new plantacionesAporte entity.
     *
     * @Route("/new", name="plantacionesaportes_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $plantacionesAporte = new Plantacionesaporte();
        $form = $this->createForm('AppBundle\Form\PlantacionesAportesType', $plantacionesAporte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($plantacionesAporte);
            $em->flush($plantacionesAporte);

            return $this->redirectToRoute('plantacionesaportes_show', array('id' => $plantacionesAporte->getId()));
        }

        return $this->render('plantacionesaportes/new.html.twig', array(
            'plantacionesAporte' => $plantacionesAporte,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a plantacionesAporte entity.
     *
     * @Route("/{id}", name="plantacionesaportes_show")
     * @Method("GET")
     */
    public function showAction(PlantacionesAportes $aporte, $id)
    {
      $em    = $this->get('doctrine.orm.entity_manager');
      $plantacione = $em->getRepository('AppBundle:Plantaciones')->findOneBy(array('id'=>$id));
      //$deleteForm = $this->createDeleteForm($plantacione);
      return $this->render('plantacionesaportes/show.html.twig', array(
            'plantacione' => $plantacione,
            'aporte' => $aporte,
            //'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing plantacionesAporte entity.
     *
     * @Route("/{id}/edit", name="plantacionesaportes_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, PlantacionesAportes $plantacionesAporte)
    {
        $deleteForm = $this->createDeleteForm($plantacionesAporte);
        $editForm = $this->createForm('AppBundle\Form\PlantacionesAportesType', $plantacionesAporte);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('plantacionesaportes_edit', array('id' => $plantacionesAporte->getId()));
        }

        return $this->render('plantacionesaportes/edit.html.twig', array(
            'plantacionesAporte' => $plantacionesAporte,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a plantacionesAporte entity.
     *
     * @Route("/{id}", name="plantacionesaportes_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, PlantacionesAportes $plantacionesAporte)
    {
        $form = $this->createDeleteForm($plantacionesAporte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($plantacionesAporte);
            $em->flush($plantacionesAporte);
        }

        return $this->redirectToRoute('plantacionesaportes_index');
    }

    /**
     * Creates a form to delete a plantacionesAporte entity.
     *
     * @param PlantacionesAportes $plantacionesAporte The plantacionesAporte entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PlantacionesAportes $plantacionesAporte)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('plantacionesaportes_delete', array('id' => $plantacionesAporte->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
