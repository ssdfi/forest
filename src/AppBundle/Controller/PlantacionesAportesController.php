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
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $plantaciones = $paginator->paginate(
              $query,
              $request->query->getInt('page', 1),
              15,
              array('defaultSortFieldName' => 'a.id', 'defaultSortDirection' => 'asc')
          );
        return $this->render('plantacionesaportes/index.html.twig', array('plantaciones' => $plantaciones));
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
        $plantacione = $em->getRepository('AppBundle:Plantaciones')->findOneBy(array('id'=>$aporte->getIdOrig()));
        $plantacion = $this->getGeoJSON($id);
        return $this->render('plantacionesaportes/show.html.twig', array(
            'plantacione' => $plantacione,
            'plantacion' => $plantacion,
            'aporte' => $aporte
        ));
    }
    /* Obtengo Plantacion, Aporte y Diferencia*/
    public function getGeoJSON($id)
    {
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql_plantacion ="SELECT ST_AsGeoJson(ST_TRANSFORM(p.geom,4326)) as plantacion,
                        ST_AsGeoJson(ST_TRANSFORM(pa.geom,4326)) as plantacion_aporte,
                        ST_EQUALS(pa.geom,p.geom) as diff,
                        ST_AREA(p.geom)/10000 as superficieOriginal,
                        ST_AREA(pa.geom)/10000 as superficieAporte
                FROM AppBundle:Plantaciones p
                JOIN AppBundle:PlantacionesAportes pa WITH pa.idOrig=p.id
                WHERE pa.id=:id";
        $plantacion=$em->createQuery($dql_plantacion)->setParameters(array('id' => $id))->getResult(Query::HYDRATE_OBJECT);
        return $plantacion;
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
            try {
              $this->getDoctrine()->getManager()->flush();
                $this->get('session')->getFlashBag()->add('notice', array('type' => 'success', 'title' => '', 'message' => 'Aporte editado satisfactoriamente.'));
                return $this->redirectToRoute('plantacionesaportes_show', array('id' => $plantacionesAporte->getId()));
            } catch (\Doctrine\ORM\ORMException $e) {
                $this->get('session')->getFlashBag()->add('error', 'Ocurrió un error al editar el aporte');
                $this->get('logger')->error($e->getMessage());
                return $this->redirectToRoute('plantacionesaportes_index');
            }

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
