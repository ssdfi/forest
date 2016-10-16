<?php

namespace AppBundle\Controller;


use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Plantaciones;
use AppBundle\Form\PlantacionesType;
use CrEOF\Spatial\PHP\Types\Geometry\LineString;
use CrEOF\Spatial\PHP\Types\Geometry\Point;
use CrEOF\Spatial\PHP\Types\Geometry\Polygon;
use CrEOF\Spatial\Tests\Fixtures\PolygonEntity;
use CrEOF\Spatial\Tests\OrmTestCase;

use Doctrine\ORM\Query;
/**
 * Plantaciones controller.
 *
 * @Route("/plantaciones")
 */
class PlantacionesController extends Controller
{
    //protected $em;

    /**
     * Lists all Plantaciones entities.
     *
     * @Route("/", name="plantaciones_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT a FROM AppBundle:Plantaciones a";
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

        return $this->render('plantaciones/index.html.twig',array('plantaciones' => $plantaciones));
    }
    /**
     * Get hectarea value
     */
    public function getHectarea($geom)
    {
        return 'hola';
    }

    /**
     * Creates a new Plantaciones entity.
     *
     * @Route("/new", name="plantaciones_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $plantacione = new Plantaciones();
        $form = $this->createForm('AppBundle\Form\PlantacionesType', $plantacione);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($plantacione);
            $em->flush();

            return $this->redirectToRoute('plantaciones_show', array('id' => $plantacione->getId()));
        }

        return $this->render('plantaciones/new.html.twig', array(
            'plantacione' => $plantacione,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Plantaciones entity.
     *
     * @Route("/{id}", name="plantaciones_show")
     * @Method("GET")
     */
    public function showAction(Plantaciones $plantacione, $id)
    {
      $em    = $this->get('doctrine.orm.entity_manager');
      $dql_m   = "SELECT m
                FROM AppBundle:Plantaciones p
                JOIN AppBundle:ActividadesPlantaciones ap WITH p.id=ap.plantacion
                JOIN AppBundle:Actividades a WITH a.id=ap.actividad
                JOIN AppBundle:Movimientos m WITH m.id=a.movimiento
                JOIN AppBundle:Expedientes e WITH e.id=m.expediente
                WHERE p.id=:id";
      $movimientos=$em->createQuery($dql_m)->setParameters(array('id' => $id))->getResult(Query::HYDRATE_OBJECT);

      $dql_e   = "SELECT e
                FROM AppBundle:Plantaciones p
                JOIN AppBundle:ActividadesPlantaciones ap WITH p.id=ap.plantacion
                JOIN AppBundle:Actividades a WITH a.id=ap.actividad
                JOIN AppBundle:Movimientos m WITH m.id=a.movimiento
                JOIN AppBundle:Expedientes e WITH e.id=m.expediente
                WHERE p.id=:id";
      $expedientes=$em->createQuery($dql_e)->setParameters(array('id' => $id))->getResult(Query::HYDRATE_OBJECT);

      $dql_a   = "SELECT a
                FROM AppBundle:Plantaciones p
                JOIN AppBundle:ActividadesPlantaciones ap WITH p.id=ap.plantacion
                JOIN AppBundle:Actividades a WITH a.id=ap.actividad
                JOIN AppBundle:Movimientos m WITH m.id=a.movimiento
                JOIN AppBundle:Expedientes e WITH e.id=m.expediente
                WHERE p.id=:id";
      //SELECT a , st_area(a.geom)/10000 FROM AppBundle:Plantaciones a";
      $actividades=$em->createQuery($dql_a)->setParameters(array('id' => $id))->getResult(Query::HYDRATE_OBJECT);

      //historico_anterior
      $deleteForm = $this->createDeleteForm($plantacione);
      return $this->render('plantaciones/show.html.twig', array(
            'plantacione' => $plantacione,
            'movimientos' => $movimientos,
            'actividades' => $actividades,
            'expedientes' => $expedientes,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Plantaciones entity.
     *
     * @Route("/{id}/edit", name="plantaciones_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Plantaciones $plantacione)
    {
        $deleteForm = $this->createDeleteForm($plantacione);
        $editForm = $this->createForm('AppBundle\Form\PlantacionesType', $plantacione);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($plantacione);
            $em->flush();

            return $this->redirectToRoute('plantaciones_edit', array('id' => $plantacione->getId()));
        }

        return $this->render('plantaciones/edit.html.twig', array(
            'plantacione' => $plantacione,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Plantaciones entity.
     *
     * @Route("/{id}", name="plantaciones_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Plantaciones $plantacione)
    {
        $form = $this->createDeleteForm($plantacione);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($plantacione);
            $em->flush();
        }

        return $this->redirectToRoute('plantaciones_index');
    }

    /**
     * Creates a form to delete a Plantaciones entity.
     *
     * @param Plantaciones $plantacione The Plantaciones entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Plantaciones $plantacione)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('plantaciones_delete', array('id' => $plantacione->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
