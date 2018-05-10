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
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\PlantacionesHistorico;
use AppBundle\Entity\Especies;
use Doctrine\ORM\Query\ResultSetMapping;

use Doctrine\ORM\Query;

/**
 * Plantaciones controller.
 *
 * @Route("/plantaciones")
 */
class PlantacionesController extends Controller
{
    /**
     * Displays a form to edit an existing Plantaciones entity.
     * @Route("/editar", name="plantaciones_editar")
     * @Method({"GET", "POST"})
     */
    public function editarAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $param=$request->query->get('plantacion');
        $actividad = $request->query->get('actividad_id');
        if ($param['ids'] || $actividad) {
          $p_actividad = array();
            if($actividad){
              $plantaciones_actividad = $em->getRepository('AppBundle:Actividades')->findOneById($actividad);
              foreach ($plantaciones_actividad->getPlantaciones() as $k => $v) {
                $p_actividad[$k] = $v->getPlantacion();
              }
            }
            $param = ($p_actividad)? $p_actividad : array_filter(explode("\r\n", $param['ids']));
            $plantacione = new Plantaciones();
            $generos = $em->getRepository('AppBundle:Generos')->findAll();
            $editForm = $this->createForm('AppBundle\Form\PlantacionesEditarType', $plantacione, array('param'=>$param));
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    foreach ($param as $value) {
                        $plantacion_actualizar = $em->getRepository('AppBundle:Plantaciones')->findOneById($value);
                        if ($plantacion_actualizar) {
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
                          if (!$plantacione->getEspecie()->isEmpty()) { $plantacion_actualizar->setEspecie($plantacione->getEspecie()); }
                          $em->persist($plantacion_actualizar);
                        }
                    }
                    $em->flush();
                    $this->get('session')->getFlashBag()->add('notice', array('type' => 'success', 'title' => 'Editar Plantación', 'message' => 'Se ha editado correctamente la plantación.'));
                    return $this->redirectToRoute('plantaciones_index',array('plantacion[ids]'=>implode("\r\n",$param)));
                } catch (\Doctrine\ORM\ORMException $e) {
                    $this->get('session')->getFlashBag()->add('error', 'Ocurrió un error al editar la plantación');
                    $this->get('logger')->error($e->getMessage());
                    return $this->redirect('plantaciones_index');
                }
            }

            return $this->render('plantaciones/editar.html.twig', array(
            'plantacione' => $plantacione,
            'generos' => $generos,
            'edit_form' => $editForm->createView(),
        ));
        } else {
            $dql   = "SELECT a FROM AppBundle:Plantaciones a";
            $query = $em->createQuery($dql);
            $paginator = $this->get('knp_paginator');
            $this->get('session')->getFlashBag()->add('error', "Debe ingresar al menos un 'id' de plantación para editar");
            $plantaciones = $paginator->paginate(
                $query,
                $request->query->getInt('page', 1),
                15,
                array('defaultSortFieldName' => 'a.id', 'defaultSortDirection' => 'asc')
            );
            return $this->render('plantaciones/index.html.twig', array('plantaciones' => $plantaciones, 'param'=> $param));
        }
    }

    /**
     * Lists all Plantaciones entities.
     *
     * @Route("/", name="plantaciones_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $param=$request->query->get('plantacion');
        $queries = null;
        if ($param['ids']) {
            $str = $param['ids'];
            $param = explode("\r\n", $str);
            $ids = [];
            foreach ($param as $key => $value) {
              if (!empty($value)) {
                $ids[]= $value;
              }
            }
            $queries = $em->createQuery('SELECT p as plantacion, st_area(p.geom)/10000 as area FROM AppBundle:Plantaciones p WHERE p.id IN (:ids)');
            $queries->setParameter('ids', $ids);
        } else {
          $qb = $em->createQueryBuilder();
          $qb->select('p as plantacion, st_area(p.geom)/10000 as area')
             ->from('AppBundle:Plantaciones', 'p')
             ->orderBy('p.id', 'ASC');
        }
        $paginator = $this->get('knp_paginator');
        $plantaciones = $paginator->paginate(
                $queries ? $queries : $qb,
                $request->query->getInt('page', 1),
                15,
                array('wrap-queries'=>true,'distinct' => false)
            );

        return $this->render('plantaciones/index.html.twig', array('plantaciones' => $plantaciones, 'param'=> $param));
    }

    /**
     * Creates a new Plantaciones entity.
     *
     * @Route("/new", name="plantaciones_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $plantacione = new Plantaciones();
        $form = $this->createForm('AppBundle\Form\PlantacionesType', $plantacione);
        $generos = $em->getRepository('AppBundle:Generos')->findAll();
        $plantaciones_historicos = $em->getRepository('AppBundle:PlantacionesHistorico')->findByPlantacionAnterior($plantacione->getId());
        $originalHistoricos = new ArrayCollection();
        foreach ($plantaciones_historicos as $plantacionHistorico) {
            $originalHistoricos->add($plantacionHistorico);
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $copiarDatos = $form->get("copiarDatos")->getData();
            $activarNuevas = $form->get("activarNuevas")->getData();
            foreach ($originalHistoricos as $key => $value) {
                if (false == $plantacione->getHistorico()->contains($value->getPlantacionNueva()->getId())) {
                    $historico = $em->getRepository('AppBundle:PlantacionesHistorico')->findBy(array('plantacionNueva'=>$value,'plantacionAnterior'=>$plantacione->getId()));
                    $plantacione->removeHistorico($value);
                    $em->remove($value);
                }
            }
            foreach ($plantacione->getHistorico() as $key => $value) {
                $historico = $em->getRepository('AppBundle:PlantacionesHistorico')->findOneBy(array('plantacionNueva'=>$value,'plantacionAnterior'=>$plantacione->getId()));
                $plantacione->setHistorico($historico);
                if (is_integer($value)) {
                    $plantacione->getHistorico()->removeElement($value);
                }
            }

            if (count($plantacione->getHistorico()) > 0) {
                $plantacione->setActivo(false);
            }

            if ($copiarDatos === true) {
                foreach ($plantacione->getHistorico() as $key => $plantacionNueva) {
                    $plantacionNueva->getPlantacionNueva()->setActivo($activarNuevas);
                    $plantacionNueva->getPlantacionNueva()->setTitular($plantacione->getTitular());
                    $plantacionNueva->getPlantacionNueva()->setEspecie($plantacione->getEspecie());
                    $plantacionNueva->getPlantacionNueva()->setAnioPlantacion($plantacione->getAnioPlantacion());
                    $plantacionNueva->getPlantacionNueva()->setTipoPlantacion($plantacione->getTipoPlantacion());
                    $plantacionNueva->getPlantacionNueva()->setNomenclaturaCatastral($plantacione->getNomenclaturaCatastral());
                    $plantacionNueva->getPlantacionNueva()->setProvincia($plantacione->getProvincia());
                    $plantacionNueva->getPlantacionNueva()->setDepartamento($plantacione->getDepartamento());
                    $plantacionNueva->getPlantacionNueva()->setEstratoDesarrollo($plantacione->getEstratoDesarrollo());
                    $plantacionNueva->getPlantacionNueva()->setUsoForestal($plantacione->getUsoForestal());
                    $plantacionNueva->getPlantacionNueva()->setUsoAnterior($plantacione->getUsoAnterior());
                    $plantacionNueva->getPlantacionNueva()->setObjetivoPlantacion($plantacione->getObjetivoPlantacion());
                }
            }
            try {
                $em->persist($plantacione);
                $em->flush();
                $this->get('session')->getFlashBag()->add('notice', array('type' => 'success', 'title' => 'Editar Plantación', 'message' => 'Se ha editado correctamente la plantación.'));
                return $this->redirectToRoute('plantaciones_show', array('id' => $plantacione->getId()));
            } catch (\Doctrine\ORM\ORMException $e) {
                $this->get('session')->getFlashBag()->add('error', 'Ocurrió un error al editar la plantación');
                $this->get('logger')->error($e->getMessage());
                return $this->redirect('plantaciones_show', array('id' => $plantacione->getId()));
            }
        }

        return $this->render('plantaciones/new.html.twig', array(
            'plantacione' => $plantacione,
            'generos'=>$generos,
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
        $em = $this->getDoctrine()->getManager();
        $dql_pr   = "SELECT p as plantacione, ap as actividadPlantacion, a as actividades, m as movimientos, e as expedientes, ST_AREA(p.geom)/10000 as area
                FROM AppBundle:Plantaciones p
                LEFT JOIN AppBundle:ActividadesPlantaciones ap WITH p.id=ap.plantacion
                LEFT JOIN AppBundle:Actividades a WITH a.id=ap.actividad
                LEFT JOIN AppBundle:Movimientos m WITH m.id=a.movimiento
                LEFT JOIN AppBundle:Expedientes e WITH e.id=m.expediente
                WHERE p.id=:id";
        $query = $em->createQuery($dql_pr)->setParameters(array('id' => $id))->getResult(Query::HYDRATE_OBJECT);
        $arr_query = array();
        foreach ($query as $item) {
            foreach ($item as $key => $value) {
                if ($value != null){
                  $arr_query[$key][] = $value;
                }
            }
        }
        $plantaciones_anteriores = $em->getRepository('AppBundle:PlantacionesHistorico')->findPlantacionNuevaWithArea($plantacione->getId());
        $plantaciones_nuevas = $em->getRepository('AppBundle:PlantacionesHistorico')->findPlantacionAnteriorWithArea($plantacione->getId());
        $deleteForm = $this->createDeleteForm($plantacione);
        return $this->render('plantaciones/show.html.twig', array(
            'plantacione' => $plantacione,
            'area'=> (array_key_exists('area', $arr_query)) ? $arr_query['area'][0] : null,
            'movimientos' => (array_key_exists('movimientos', $arr_query)) ? $arr_query['movimientos'] : null,
            'actividades' => (array_key_exists('actividades', $arr_query)) ? $arr_query['actividades'] : null,
            'expedientes' => (array_key_exists('expedientes', $arr_query)) ? $arr_query['expedientes'] : null,
            'plantacionAnterior' => $plantaciones_anteriores,
            'plantacionNueva'=> $plantaciones_nuevas,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Plantaciones entity.
     * @Route("/{id}/edit", name="plantaciones_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Plantaciones $plantacione)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($plantacione);
        $generos = $em->getRepository('AppBundle:Generos')->findAll();
        $plantaciones_historicos = $em->getRepository('AppBundle:PlantacionesHistorico')->findByPlantacionAnterior($plantacione->getId());
        $originalHistoricos = new ArrayCollection();
        foreach ($plantaciones_historicos as $plantacionHistorico) {
            $originalHistoricos->add($plantacionHistorico);
        }
        $editForm = $this->createForm('AppBundle\Form\PlantacionesType', $plantacione);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $copiarDatos = $editForm->get("copiarDatos")->getData();
            $activarNuevas = $editForm->get("activarNuevas")->getData();
            foreach ($originalHistoricos as $key => $value) {
                if (false == $plantacione->getHistorico()->contains($value->getPlantacionNueva()->getId())) {
                    $historico = $em->getRepository('AppBundle:PlantacionesHistorico')->findBy(array('plantacionNueva'=>$value,'plantacionAnterior'=>$plantacione->getId()));
                    $plantacione->removeHistorico($value);
                    $em->remove($value);
                }
            }
            foreach ($plantacione->getHistorico() as $key => $value) {
                $historico = $em->getRepository('AppBundle:PlantacionesHistorico')->findOneBy(array('plantacionNueva'=>$value,'plantacionAnterior'=>$plantacione->getId()));
                $plantacione->setHistorico($historico);
                if (is_integer($value)) {
                    $plantacione->getHistorico()->removeElement($value);
                }
            }

            if (count($plantacione->getHistorico()) > 0) {
                $plantacione->setActivo(false);
            }

            if ($copiarDatos === true) {
                foreach ($plantacione->getHistorico() as $key => $plantacionNueva) {
                    $plantacionNueva->getPlantacionNueva()->setActivo($activarNuevas);
                    $plantacionNueva->getPlantacionNueva()->setTitular($plantacione->getTitular());
                    $plantacionNueva->getPlantacionNueva()->setEspecie($plantacione->getEspecie());
                    $plantacionNueva->getPlantacionNueva()->setAnioPlantacion($plantacione->getAnioPlantacion());
                    $plantacionNueva->getPlantacionNueva()->setTipoPlantacion($plantacione->getTipoPlantacion());
                    $plantacionNueva->getPlantacionNueva()->setNomenclaturaCatastral($plantacione->getNomenclaturaCatastral());
                    $plantacionNueva->getPlantacionNueva()->setProvincia($plantacione->getProvincia());
                    $plantacionNueva->getPlantacionNueva()->setDepartamento($plantacione->getDepartamento());
                    $plantacionNueva->getPlantacionNueva()->setEstratoDesarrollo($plantacione->getEstratoDesarrollo());
                    $plantacionNueva->getPlantacionNueva()->setUsoForestal($plantacione->getUsoForestal());
                    $plantacionNueva->getPlantacionNueva()->setUsoAnterior($plantacione->getUsoAnterior());
                    $plantacionNueva->getPlantacionNueva()->setObjetivoPlantacion($plantacione->getObjetivoPlantacion());
                }
            }
            try {
                $em->persist($plantacione);
                $em->flush();
                $this->get('session')->getFlashBag()->add('notice', array('type' => 'success', 'title' => 'Editar Plantación', 'message' => 'Se ha editado correctamente la plantación.'));
                return $this->redirectToRoute('plantaciones_show', array('id' => $plantacione->getId()));
            } catch (\Doctrine\ORM\ORMException $e) {
                $this->get('session')->getFlashBag()->add('error', 'Ocurrió un error al editar la plantación');
                $this->get('logger')->error($e->getMessage());
                return $this->redirect('plantaciones_show', array('id' => $plantacione->getId()));
            }
        }

        return $this->render('plantaciones/edit.html.twig', array(
            'plantacione' => $plantacione,
            'generos' => $generos,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /* Obtengo Plantacion*/
    /**
     * Finds and displays a Plantaciones entity.
     *
     * @Route("/json/{id}", name="sjson_plantacion")
     * @Method("GET")
     */
    public function jsonAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $dql_p   = "SELECT st_area(p.geom)/10000
                    FROM AppBundle:Plantaciones p
                    WHERE p.id=:id";
        $plantacion=$em->createQuery($dql_p)->setParameters(array('id' => $id))->getResult();
        $response = new Response();
        if (!empty($plantacion)) {
            $plantacion[0][1] = round($plantacion[0][1], 1, PHP_ROUND_HALF_UP);
            $response->setContent(json_encode($plantacion[0]));
        }
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    /* Obtengo Plantacion*/
    /**
     * Finds and displays a Plantaciones entity.
     *
     * @Route("/geojson/{id}", name="geojson_plantacion")
     * @Method("GET")
     */
    public function getGeoJSON($id)
    {
        $em    = $this->getDoctrine()->getManager();
        $dql_plantacion ="SELECT ST_AsGeoJson(ST_TRANSFORM(p.geom,4326)) as plantacion
                  FROM AppBundle:Plantaciones p
                  WHERE p.id=:id";
        $plantacion=$em->createQuery($dql_plantacion)->setParameters(array('id' => $id))->getResult(Query::HYDRATE_OBJECT);
        return $plantacion;
    }

    /* Obtengo Especies*/
    /**
     * Finds and displays a Plantaciones entity.
     *
     * @Route("/especie_json/", name="json_especies")
     * @Method("GET")
     */
    public function jsonEspeciesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $param=$request->query->get('especie');
        $wheres=array();

        if ($param['genero_id']) {
            $genero=$param['genero_id'];
            $wheres[]="a.genero = $genero";
        }
        if ($param['codigo_sp']) {
            $codigo_sp=$param['codigo_sp'];
            $wheres[]="lower(a.codigoSp) like lower('%$codigo_sp%')";
        }
        if ($param['nombre_cientifico']) {
            $nombre_cientifico=$param['nombre_cientifico'];
            $wheres[]="lower(a.nombreCientifico) like lower('%$nombre_cientifico%')";
        }
        if ($param['nombre_comun']) {
            $nombre_comun=$param['nombre_comun'];
            $wheres[]="lower(a.nombreComun) like lower('%$nombre_comun%')";
        }
        $filter = '';
        foreach ($wheres as $key => $value) {
            $filter = $filter .' '.$value;
            if (count($wheres) > 1 && $value != end($wheres)) {
                $filter = $filter .' AND';
            }
        }
        $dql   = "SELECT a FROM AppBundle:Especies a";
        if (!empty($wheres)) {
            $dql = $dql .' WHERE '.$filter;
        }
        $query = $em->createQuery($dql);

        $result=$query->getResult((\Doctrine\ORM\Query::HYDRATE_ARRAY));

        if (!empty($wheres)) {
            //$dql=implode("and",$wheres);
        }
        $response = new Response();
        $response->setContent(json_encode($result));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
    /**
     * Finds and displays a Plantaciones entity's Map.
     *
     * @Route("/{id}/mapa", name="json_plantacion")
     * @Method("GET")
     */
    public function mapAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $dql_p   = "SELECT
                    p.id as id,
                    t.nombre as titular,
                    e.nombreCientifico as especie,
                    st_area(p.geom)/10000 as area,
                    ST_AsGeoJson(ST_TRANSFORM(p.geom,4326)) as plantacion
                  FROM AppBundle:Plantaciones p
                  LEFT JOIN AppBundle:Titulares t WITH p.titular = t.id
                  LEFT JOIN AppBundle:EspeciesPlantaciones ep WITH p.id = ep.plantacion
                  LEFT JOIN AppBundle:Especies e WITH ep.especie = e.id
                  WHERE p.id=:id";
        $plantaciones=$em->createQuery($dql_p)->setParameters(array('id' => $id))->getResult();
        $data = '';
        foreach ($plantaciones as $key => $plantacion) {
            $data[$key]['id']= $plantacion['id'];
            $data[$key]['type']= "Feature";
            $data[$key]['geometry']=json_decode($plantacion['plantacion']);
            $data[$key]['properties']['ID']=$plantacion['id'];
            $data[$key]['properties']['Titular']=$plantacion['titular'];
            $data[$key]['properties']['Especie']=$plantacion['especie'];
            $data[$key]['properties']['Superficie']=round($plantacion['area'], 1);
        }
        return $this->render('map.html.twig', array('plantacion'=>json_encode($data)));
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
            try {
                $em = $this->getDoctrine()->getManager();
                $em->remove($plantacione);
                $em->flush();
                $this->get('session')->getFlashBag()->add('notice', array('type' => 'success', 'title' => 'Editar Plantación', 'message' => 'Se ha eliminado correctamente la plantación.'));
                return $this->redirectToRoute('plantaciones_index');
            } catch (\Doctrine\ORM\ORMException $e) {
                $this->get('session')->getFlashBag()->add('error', 'Ocurrió un error al eliminar la plantación');
                $this->get('logger')->error($e->getMessage());
                return $this->redirect('plantaciones_index');
            }
        }
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
