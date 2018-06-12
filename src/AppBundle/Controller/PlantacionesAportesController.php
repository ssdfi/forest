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
     * Displays a form to edit an existing Plantaciones entity.
     * @Route("/editar", name="plantaciones_aportes_editar")
     * @Method({"GET", "POST"})
     */
    public function editarAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $param=$request->query->get('plantacion');
        if ($param['ids']) {
            $param = array_filter(explode("\r\n", $param['ids']));
            $plantacione = new PlantacionesAportes();
            $generos = $em->getRepository('AppBundle:Generos')->findAll();
            $editForm = $this->createForm('AppBundle\Form\PlantacionesAportesEditarType', $plantacione, array('param'=>$param));
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    foreach ($param as $value) {
                        $plantacion_actualizar = $em->getRepository('AppBundle:PlantacionesAportes')->findOneById($value);
                        if ($plantacion_actualizar && $plantacion_actualizar->getUsuario()== $this->getUser()->getUsername()) {
                          if ($plantacione->getNumeroInterno()) { $plantacion_actualizar->setNumeroInterno($plantacione->getNumeroInterno()); }
                          if ($plantacione->getAnioPlantacion()) { $plantacion_actualizar->setAnioPlantacion($plantacione->getAnioPlantacion()); }
                          if ($plantacione->getNomenclaturaCatastral()) { $plantacion_actualizar->setNomenclaturaCatastral($plantacione->getNomenclaturaCatastral()); }
                          if ($plantacione->getDistanciaPlantas()) { $plantacion_actualizar->setDistanciaPlantas($plantacione->getDistanciaPlantas()); }
                          if ($plantacione->getCantidadFilas()) { $plantacion_actualizar->setCantidadFilas($plantacione->getCantidadFilas()); }
                          if ($plantacione->getDistanciaFilas()) { $plantacion_actualizar->setDistanciaFilas($plantacione->getDistanciaFilas()); }
                          if ($plantacione->getDensidad()) { $plantacion_actualizar->setDensidad($plantacione->getDensidad()); }
                          if ($plantacione->getAnioInformacion()) { $plantacion_actualizar->setAnioInformacion($plantacione->getAnioInformacion()); }
                          if ($plantacione->getFechaImagen()) { $plantacion_actualizar->setFechaImagen($plantacione->getFechaImagen()); }
                          if ($plantacione->getActivo()) { $plantacion_actualizar->setActivo($plantacione->getActivo()); }
                          if ($plantacione->getComentarios()) { $plantacion_actualizar->setComentarios($plantacione->getComentarios()); }
                          if ($plantacione->getMpfId()) { $plantacion_actualizar->setMpfId($plantacione->getMpfId()); }
                          if ($plantacione->getUnificadoId()) { $plantacion_actualizar->setUnificadoId($plantacione->getUnificadoId()); }
                          if ($plantacione->getBaseGeometricaId()) { $plantacion_actualizar->setBaseGeometricaId($plantacione->getBaseGeometricaId()); }
                          if ($plantacione->getError()) { $plantacion_actualizar->setError($plantacione->getError()); }
                          if ($plantacione->getEstadoPlantacion()) { $plantacion_actualizar->setEstadoPlantacion($plantacione->getEstadoPlantacion()); }
                          if ($plantacione->getEstratoDesarrollo()) { $plantacion_actualizar->setEstratoDesarrollo($plantacione->getEstratoDesarrollo()); }
                          if ($plantacione->getFuenteImagen()) { $plantacion_actualizar->setFuenteImagen($plantacione->getFuenteImagen()); }
                          if ($plantacione->getFuenteInformacion()) { $plantacion_actualizar->setFuenteInformacion($plantacione->getFuenteInformacion()); }
                          if ($plantacione->getObjetivoPlantacion()) { $plantacion_actualizar->setObjetivoPlantacion($plantacione->getObjetivoPlantacion()); }
                          if ($plantacione->getTipoPlantacion()) { $plantacion_actualizar->setTipoPlantacion($plantacione->getTipoPlantacion()); }
                          if ($plantacione->getTitular()) { $plantacion_actualizar->setTitular($plantacione->getTitular()); }
                          if ($plantacione->getUsoAnterior()) { $plantacion_actualizar->setUsoAnterior($plantacione->getUsoAnterior()); }
                          if ($plantacione->getUsoForestal()) { $plantacion_actualizar->setUsoForestal($plantacione->getUsoForestal()); }
                          if ($plantacione->getProvincia()) { $plantacion_actualizar->setProvincia($plantacione->getProvincia()); }
                          if ($plantacione->getDepartamento()) { $plantacion_actualizar->setDepartamento($plantacione->getDepartamento()); }
                          // if ($plantacione->getDosel()) { $plantacion_actualizar->setDosel($plantacione->getDosel()); }
                          if (!$plantacione->getEspecie()->isEmpty()) { $plantacion_actualizar->setEspecie($plantacione->getEspecie()); }
                          $em->persist($plantacion_actualizar);
                        }
                    }
                    $em->flush();
                    $this->get('session')->getFlashBag()->add('notice', array('type' => 'success', 'title' => 'Editar Plantación', 'message' => 'Se ha editado correctamente la plantación.'));
                    return $this->redirectToRoute('plantacionesaportes_index',array('plantacion[ids]'=>implode("\r\n",$param)));
                } catch (\Doctrine\ORM\ORMException $e) {
                    $this->get('session')->getFlashBag()->add('error', 'Ocurrió un error al editar la plantación');
                    $this->get('logger')->error($e->getMessage());
                    return $this->redirect('plantacionesaportes_index');
                }
            }

            return $this->render('plantacionesaportes/editar.html.twig', array(
            'plantacione' => $plantacione,
            'generos' => $generos,
            'edit_form' => $editForm->createView(),
        ));
        } else {
            $dql   = "SELECT a FROM AppBundle:PlantacionesAportes a";
            $query = $em->createQuery($dql);
            $paginator = $this->get('knp_paginator');
            $this->get('session')->getFlashBag()->add('error', "Debe ingresar al menos un 'id' de plantación para editar");
            $plantaciones = $paginator->paginate(
                $query,
                $request->query->getInt('page', 1),
                15,
                array('defaultSortFieldName' => 'a.id', 'defaultSortDirection' => 'asc')
            );
            return $this->render('plantacionesaportes/index.html.twig', array('plantaciones' => $plantaciones, 'param'=> $param));
        }
      }
    /**
     * Lists all plantacionesAporte entities.
     *
     * @Route("/", name="plantacionesaportes_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $param=$request->query->get('plantacion');
        $ids = [];
        if ($param['ids']) {
            $str = $param['ids'];
            $param = explode("\r\n", $str);
            foreach ($param as $key => $value) {
              if (!empty($value)) {
                $ids[]= $value;
              }
            }
        }
        $ck = $em->createQueryBuilder();
        $ck->select('p')
            ->from('AppBundle:PlantacionesAportes', 'p');

        if ($this->isGranted('ROLE_TECNICO_REGIONAL')) {
          $ck->andWhere('p.usuario = :Usuario');
          $ck->setParameter('Usuario',$this->getUser()->getUsername());
        }
        if ($param && $ids) {
          $ck->andWhere('p.id IN (:Ids)');
          $ck->setParameter('Ids',$ids);
        }
        $query = $ck->getQuery()->getResult();
        $paginator = $this->get('knp_paginator');
        $plantaciones = $paginator->paginate(
              $query,
              $request->query->getInt('page', 1),
              15,
              array('defaultSortFieldName' => 'id', 'defaultSortDirection' => 'asc')
          );
        return $this->render('plantacionesaportes/index.html.twig', array('plantaciones' => $plantaciones,'param'=>$param));
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
        $plantacion = $em->getRepository('AppBundle:PlantacionesAportes')->findPlantacionWithArea($aporte->getId());
        return $this->render('plantacionesaportes/show_insert.html.twig', array(
            'plantacione' => $plantacion['plantacion'],
            'area' => $plantacion['area'],
            'geom' => $plantacion['geom'],
            'aporte'=>$aporte
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
       if ($plantacionesAporte->getUsuario() == $this->getUser()->getUsername() || $this->isGranted('ROLE_ADMIN')) {
          $em    = $this->get('doctrine.orm.entity_manager');
          $deleteForm = $this->createDeleteForm($plantacionesAporte);
          $editForm = $this->createForm('AppBundle\Form\PlantacionesAportesType', $plantacionesAporte);
          $generos = $em->getRepository('AppBundle:Generos')->findAll();
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
              'generos'=>$generos,
              'delete_form' => $deleteForm->createView(),
          ));
      }
      $this->get('session')->getFlashBag()->add('notice', array('type' => 'error', 'title' => '', 'message' => 'No puede editar un aporte que no sea el de usted.'));
      return $this->redirectToRoute('plantacionesaportes_index');
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
