<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PlantacionesAportes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @Route("/mapa", name="plantacionesaportes_index_mapa")
     * @Method({"GET", "POST"})
     */
    public function mapaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $db = $em->getConnection();

        $provincia = $request->request->get("provincia");
        $departamento = $request->request->get("departamento");
        
        $plantacionesArray = [];
        if(!is_null($provincia) && !is_null($departamento)){
            $query = "SELECT p.nombre as provincia, d.nombre as departamento, t.nombre as titular, ST_AsGeoJson(ST_TRANSFORM(pa.geom,4326)) as geom, pa.id, ST_Area(ST_Transform(pa.geom, 4326)::geography)/10000 as area, g.descripcion as genero
                    from plantaciones_aportes pa
                    left join provincias p ON pa.provincia_id = p.id
                    left join departamentos d ON pa.departamento_id = d.id
                    left join especies_plantaciones_aportes e on pa.id = e.plantacion_id
                    left join especies sp on e.especie_id = sp.id
                    left join generos g on sp.genero_id = g.id
                    left join titulares t on pa.titular_id = t.id WHERE pa.activo = true AND pa.provincia_id = $provincia ORDER BY id DESC;";
            $sql = $db->prepare($query);
            $sql->execute();
            $plantaciones = $sql->fetchAll();

            foreach ($plantaciones as $plantacion) {
                $nuevo = new \StdClass();
                $nuevo->id = $plantacion['id'];
                $nuevo->type = "Feature";
                $nuevo->geometry = json_decode($plantacion['geom']);
                $nuevo->properties = array(
                    "Id"=> $plantacion['id'], 
                    "Area"=> round($plantacion['area'],2)." Ha&sup2;",
                    "Titular"=> $plantacion['titular'],
                    "Departamento"=> $plantacion['departamento'],
                    "Provincia"=> $plantacion['provincia'],
                    "Genero"=> $plantacion['genero'],
                    "Tipo" => 1
                );
                $plantacionesArray[] = $nuevo;
                //dump($nuevo);die;
                //break;
            }
        }

        $plantacionesActivasArray = [];
        if(!is_null($provincia) && !is_null($departamento)){

            $query = "SELECT p.id, ST_AsGeoJson(ST_TRANSFORM(p.geom,4326)) as geom, g.descripcion as genero, ST_Area(ST_Transform(p.geom, 4326)::geography)/10000 as area
                FROM public.plantaciones p 
                join especies_plantaciones e on p.id = e.plantacion_id
                join especies sp on especie_id = sp.id
                join generos g on sp.genero_id = g.id               
                WHERE p.activo = 't' AND provincia_id = $provincia AND departamento_id = $departamento;";
            $sql = $db->prepare($query);
            $sql->execute();
            $plantacionesActivas = $sql->fetchAll();
            
            foreach ($plantacionesActivas as $plantacion) {
                $nuevo = new \StdClass();
                $nuevo->id = $plantacion['id'];
                $nuevo->type = "Feature";
                $nuevo->geometry = json_decode($plantacion['geom']);
                $nuevo->properties = array(
                    "Id"=> $plantacion['id'],
                    "Genero"=> $plantacion['genero'],
                    "Area"=> round($plantacion['area'],2)." Ha&sup2;",
                    "Tipo" => 2
                );
                $plantacionesActivasArray[] = $nuevo;
            }
        }
       
        $query = "SELECT id, nombre
        FROM provincias  
        ORDER BY nombre ASC";

        $sql = $db->prepare($query);
        $sql->execute();
        $provincias = $sql->fetchAll();

        return $this->render('plantacionesaportes/mapa.html.twig', array(
            'plantaciones' => json_encode($plantacionesArray),
            'plantacionesActivas' => json_encode($plantacionesActivasArray),
            'provincias' => $provincias
        ));
    }

    /**
     * Lists all plantacionesAporte entities.
     *
     * @Route("/getPartidos/{id}", name="plantacionesaportes_partidos")
     * @Method({"GET"})
     */
    public function getPartidosActivasAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $db = $em->getConnection();

        $query = "SELECT id, nombre
                FROM departamentos                 
                WHERE provincia_id = $id ORDER BY nombre ASC;";
        $sql = $db->prepare($query);
        $sql->execute();
        $departamentos = $sql->fetchAll();

        return new JsonResponse($departamentos);
    }


     /**
     * AJAX para guardar el poligono
     *
     * @Route("/crear", name="plantacionesaportes_crear")
     * @Method({"POST"})
     */
    public function crearAction(Request $request)
    {
       if($this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_TECNICO_REGIONAL')){
           
            $em    = $this->get('doctrine.orm.entity_manager');
            $db = $em->getConnection();
            $geoms = $request->request->get("geoms");
           
            $query = "INSERT INTO plantaciones_aportes (geom, activo, usuario) VALUES(ST_SetSRID(ST_GeomFromGeoJSON(:geom), 4326), true, '".$this->getUser()->getUsername()."')";
            $sql = $db->prepare($query);
            $sql->bindParam("geom", $geoms, \PDO::PARAM_STR);
            $sql->execute();
            $id = $db->lastInsertId();

            $query = "SELECT id, ST_AsGeoJson(ST_TRANSFORM(p.geom,4326)) as geom, ST_Area(ST_Transform(geom, 4326)::geography)/10000 as area FROM plantaciones_aportes p WHERE id = $id;";
            $sql = $db->prepare($query);
            $sql->execute();
            $plantacion = $sql->fetch();

            $nuevo = new \StdClass();
            $nuevo->id = $plantacion['id'];
            $nuevo->type = "Feature";
            $nuevo->geometry = json_decode($plantacion['geom']);
            $nuevo->properties = array("Id"=> $plantacion['id'], "Area"=> round($plantacion['area'],2)." Ha&sup2;");
       }
       return new JsonResponse($nuevo);
    }

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
                        if ($plantacion_actualizar && $plantacion_actualizar->getUsuario() == $this->getUser()->getUsername()) {
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
                          if (!$plantacione->getEspecie()->isEmpty()) { $plantacion_actualizar->addEspecie($plantacione->getEspecie()); }
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
     * Displays a form to edit an existing Plantaciones entity.
     * @Route("/editar/seleccion", name="plantaciones_aportes_editar_seleccion")
     * @Method({"GET", "POST"})
     */
    public function editarSeleccionAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $ids=$request->request->get('plantacion');
        if ($ids) {
            $param = array_filter(explode(",", $ids));
            $plantacione = new PlantacionesAportes();
            $generos = $em->getRepository('AppBundle:Generos')->findAll();
            $editForm = $this->createForm('AppBundle\Form\PlantacionesAportesEditarType', $plantacione, array('param'=>$param));
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    foreach ($param as $value) {
                        $plantacion_actualizar = $em->getRepository('AppBundle:PlantacionesAportes')->findOneById($value);
                        if ($plantacion_actualizar && $plantacion_actualizar->getUsuario() == $this->getUser()->getUsername() || $this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_EDITOR')) {
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
                          if (!$plantacione->getEspecie()->isEmpty()) { $plantacion_actualizar->addEspecie($plantacione->getEspecie()); }
                          $em->persist($plantacion_actualizar);
                        }
                    }
                    $em->flush();
                    $this->get('session')->getFlashBag()->add('notice', array('type' => 'success', 'title' => 'Editar Plantación', 'message' => 'Se ha editado correctamente la plantación.'));
                    return $this->redirectToRoute('plantacionesaportes_index_mapa');
                } catch (\Doctrine\ORM\ORMException $e) {
                    $this->get('session')->getFlashBag()->add('error', 'Ocurrió un error al editar la plantación');
                    $this->get('logger')->error($e->getMessage());
                    return $this->redirect('plantacionesaportes_index_mapa');
                }
            }

            return $this->render('plantacionesaportes/editar_seleccion.html.twig', array(
            'plantacione' => $plantacione,
            'params' => $ids,
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
        $query = $ck->getQuery();
        $paginator = $this->get('knp_paginator');
        $plantaciones = $paginator->paginate(
              $query,
              $request->query->getInt('page', 1),
              15,
              array('defaultSortFieldName' => 'p.id', 'defaultSortDirection' => 'asc')
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
        $plantacion = $em->getRepository('AppBundle:PlantacionesAportes')->findPlantacionWithArea($id);
        return $this->render('plantacionesaportes/show_insert.html.twig', array(
            'plantacione' => $plantacion['plantacion'],
            'area' => $plantacion['area'],
            'geom' => $plantacion['geom'],
            'aporte'=>$aporte
        ));
    }

    /**
     * Finds and displays a plantacionesAporte entity.
     *
     * @Route("/{id}/detalle", name="plantacionesaportes_show_detalle")
     * @Method("GET")
     */
    public function showDetalleAction($id)
    {
        $em    = $this->get('doctrine.orm.entity_manager');
        $plantacion = $em->getRepository('AppBundle:PlantacionesAportes')->findPlantacionWithArea($id);
        return $this->render('plantacionesaportes/show_insert_detalle.html.twig', array(
            'plantacione' => $plantacion['plantacion'],
            'area' => $plantacion['area'],
            'geom' => $plantacion['geom'],
            //'aporte'=>$aporte
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
    public function editAction(Request $request, $id)
    {   
        $em    = $this->get('doctrine.orm.entity_manager');
        $plantacionesAporte = $em->getRepository('AppBundle:PlantacionesAportes')->find($id);
        if ($plantacionesAporte->getUsuario() == $this->getUser()->getUsername() || $this->isGranted('ROLE_ADMIN')) {
          
          $deleteForm = $this->createDeleteForm($plantacionesAporte);
          $editForm = $this->createForm('AppBundle\Form\PlantacionesAportesType', $plantacionesAporte);
          $generos = $em->getRepository('AppBundle:Generos')->findAll();
          $editForm->handleRequest($request);
          
          $plantacion = $em->getRepository('AppBundle:PlantacionesAportes')->findPlantacionWithArea($plantacionesAporte->getId());

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
              'plantacione' => $plantacion['plantacion'],
              'area' => $plantacion['area'],
              'geom' => $plantacion['geom'],
          ));
      }
      $this->get('session')->getFlashBag()->add('notice', array('type' => 'error', 'title' => '', 'message' => 'No puede editar un aporte que no sea el de usted.'));
      return $this->redirectToRoute('plantacionesaportes_index');
    }

    /**
     * Displays a form to edit an existing plantacionesAporte entity.
     *
     * @Route("/{id}/editar", name="plantacionesaportes_editar_unico")
     * @Method({"GET", "POST"})
     */
    public function editarUnicoAction(Request $request, $id)
    {   
        $em    = $this->get('doctrine.orm.entity_manager');
        $plantacionesAporte = $em->getRepository('AppBundle:PlantacionesAportes')->find($id);
        if ($plantacionesAporte->getUsuario() == $this->getUser()->getUsername() || $this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_EDITOR')) {
          
            $deleteForm = $this->createDeleteForm($plantacionesAporte);
            $editForm = $this->createForm('AppBundle\Form\PlantacionesAportesType', $plantacionesAporte);
            $generos = $em->getRepository('AppBundle:Generos')->findAll();
            $editForm->handleRequest($request);
          
            $plantacion = $em->getRepository('AppBundle:PlantacionesAportes')->findPlantacionWithArea($plantacionesAporte->getId());

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    $this->getDoctrine()->getManager()->flush();
                    $this->get('session')->getFlashBag()->add('notice', array('type' => 'success', 'title' => '', 'message' => 'Aporte editado satisfactoriamente.'));
                    return $this->redirectToRoute('plantacionesaportes_index_mapa');
                } catch (\Doctrine\ORM\ORMException $e) {
                    $this->get('session')->getFlashBag()->add('error', 'Ocurrió un error al editar el aporte');
                    $this->get('logger')->error($e->getMessage());
                    return $this->redirectToRoute('plantacionesaportes_index_mapa');
                }
            }

             return $this->render('plantacionesaportes/editar_unico.html.twig', array(
                'plantacionesAporte' => $plantacionesAporte,
                'edit_form' => $editForm->createView(),
                'generos'=>$generos,
                'delete_form' => $deleteForm->createView(),
                'plantacione' => $plantacion['plantacion'],
                'area' => $plantacion['area'],
                'geom' => $plantacion['geom'],
                'id' => $id
            ));
        }
        $this->get('session')->getFlashBag()->add('notice', array('type' => 'error', 'title' => '', 'message' => 'No puede editar un aporte que no sea el de usted.'));
        return $this->render('plantacionesaportes/editar_error.html.twig');
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
    
    /**
     * AJAX para guardar el poligono
     *
     * @Route("/{id}/edit/geom", name="plantacionesaportes_edit_geom")
     * @Method({"POST"})
     */
    public function editGeomAction(Request $request)
    {
           
        $em    = $this->get('doctrine.orm.entity_manager');
        $db = $em->getConnection();
        $geoms = $request->request->get("geoms");
        $id = $request->request->get("id");
        $tipo = $request->request->get("tipo");

        if($tipo == 1){
            $plantacionesAporte = $em->getRepository('AppBundle:PlantacionesAporte')->find($id);
            if ($plantacionesAporte->getUsuario() == $this->getUser()->getUsername() || $this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_EDITOR')) {
                $query = "UPDATE plantaciones_aportes SET geom = ST_SetSRID(ST_GeomFromGeoJSON(:geom), 4326) where id = :id";
                $sql = $db->prepare($query);
                $sql->bindParam("id", $id, \PDO::PARAM_INT);
                $sql->bindParam("geom", $geoms, \PDO::PARAM_STR);
                $sql->execute();

                $query = "SELECT ST_Area(ST_Transform(geom, 4326)::geography)/10000 as area FROM plantaciones_aportes p WHERE id = $id;";
                $sql = $db->prepare($query);
                $sql->execute();
                $plantacion = $sql->fetch();
                return new JsonResponse(array("Area"=> round($plantacion['area'],2)." Ha&sup2;"));
            }
        }else{

            $plantacion = $em->getRepository('AppBundle:Plantaciones')->find($id);
            $aporte = new PlantacionesAportes();
            if ($this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_EDITOR')) {
                if ($plantacion->getAnioPlantacion()) { $aporte->setAnioPlantacion($plantacion->getAnioPlantacion()); }
                if ($plantacion->getNomenclaturaCatastral()) { $aporte->setNomenclaturaCatastral($plantacion->getNomenclaturaCatastral()); }
                if ($plantacion->getDistanciaPlantas()) { $aporte->setDistanciaPlantas($plantacion->getDistanciaPlantas()); }
                if ($plantacion->getCantidadFilas()) { $aporte->setCantidadFilas($plantacion->getCantidadFilas()); }
                if ($plantacion->getDistanciaFilas()) { $aporte->setDistanciaFilas($plantacion->getDistanciaFilas()); }
                if ($plantacion->getDensidad()) { $aporte->setDensidad($plantacion->getDensidad()); }
                if ($plantacion->getAnioInformacion()) { $aporte->setAnioInformacion($plantacion->getAnioInformacion()); }
                if ($plantacion->getFechaImagen()) { $aporte->setFechaImagen($plantacion->getFechaImagen()); }
                if ($plantacion->getActivo()) { $aporte->setActivo($plantacion->getActivo()); }
                if ($plantacion->getComentarios()) { $aporte->setComentarios($plantacion->getComentarios()); }
                if ($plantacion->getMpfId()) { $aporte->setMpfId($plantacion->getMpfId()); }
                if ($plantacion->getUnificadoId()) { $aporte->setUnificadoId($plantacion->getUnificadoId()); }
                if ($plantacion->getBaseGeometricaId()) { $aporte->setBaseGeometricaId($plantacion->getBaseGeometricaId()); }
                if ($plantacion->getError()) { $aporte->setError($plantacion->getError()); }
                if ($plantacion->getEstadoPlantacion()) { $aporte->setEstadoPlantacion($plantacion->getEstadoPlantacion()); }
                if ($plantacion->getEstratoDesarrollo()) { $aporte->setEstratoDesarrollo($plantacion->getEstratoDesarrollo()); }
                if ($plantacion->getFuenteImagen()) { $aporte->setFuenteImagen($plantacion->getFuenteImagen()); }
                if ($plantacion->getFuenteInformacion()) { $aporte->setFuenteInformacion($plantacion->getFuenteInformacion()); }
                if ($plantacion->getObjetivoPlantacion()) { $aporte->setObjetivoPlantacion($plantacion->getObjetivoPlantacion()); }
                if ($plantacion->getTipoPlantacion()) { $aporte->setTipoPlantacion($plantacion->getTipoPlantacion()); }
                if ($plantacion->getTitular()) { $aporte->setTitular($plantacion->getTitular()); }
                if ($plantacion->getUsoAnterior()) { $aporte->setUsoAnterior($plantacion->getUsoAnterior()); }
                if ($plantacion->getUsoForestal()) { $aporte->setUsoForestal($plantacion->getUsoForestal()); }
                if ($plantacion->getProvincia()) { $aporte->setProvincia($plantacion->getProvincia()); }
                if ($plantacion->getDepartamento()) { $aporte->setDepartamento($plantacion->getDepartamento()); }
                if ($plantacion->getDosel() !== null) { $aporte->setDosel($plantacion->getDosel()); }
                if (!$plantacion->getEspecie()->isEmpty()) { $aporte->addEspecie($plantacion->getEspecie()); }
                $aporte->setUsuario($this->getUser()->getUsername());

                $em->persist($aporte);
                $em->flush();

                $id = $aporte->getId();

                $query = "UPDATE plantaciones_aportes SET geom = ST_SetSRID(ST_GeomFromGeoJSON(:geom), 4326) where id = :id";
                $sql = $db->prepare($query);
                $sql->bindParam("id", $id, \PDO::PARAM_INT);
                $sql->bindParam("geom", $geoms, \PDO::PARAM_STR);
                $sql->execute();

                $query = "SELECT ST_Area(ST_Transform(geom, 4326)::geography)/10000 as area FROM plantaciones p WHERE id = $id;";
                $sql = $db->prepare($query);
                $sql->execute();
                $plantacion = $sql->fetch();
                return new JsonResponse(array("Area"=> round($plantacion['area'],2)." Ha&sup2;"));
            }
        }

        return new JsonResponse(array(false));
    }

    /**
     * AJAX para eliminar el poligono
     *
     * @Route("/{id}/eliminar", name="plantacionesaportes_eliminar")
     * @Method({"POST"})
     */
    public function eliminarAction(Request $request)
    {
       if ($plantacionesAporte->getUsuario() == $this->getUser()->getUsername() || $this->isGranted('ROLE_ADMIN')) {
           
           $em    = $this->get('doctrine.orm.entity_manager');
           $db = $em->getConnection();
           $id = $request->request->get("id");
           
           $query = "DELETE FROM plantaciones_aportes where id = :id";
           //$query = "UPDATE plantaciones_aportes SET activo = false where id = :id";
           $sql = $db->prepare($query);
           $sql->bindParam("id", $id, \PDO::PARAM_INT);
           $sql->execute();
       }
       return new JsonResponse([true]);
    }
}
