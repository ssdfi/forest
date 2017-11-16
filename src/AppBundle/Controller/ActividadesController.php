<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Actividades;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Query;
use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Actividades controller.
 *
 *
 */
class ActividadesController extends Controller
{
    /**
     * Creates a new Actividades entity.
     *
     * @Route("/expedientes/{idExp}/movimientos/{idMov}/actividades/new", name="actividades_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $idExp, $idMov)
    {
      $em = $this->getDoctrine()->getManager();
        $actividad = new Actividades();
        $form = $this->createForm('AppBundle\Form\ActividadesType', $actividad);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $movimiento = $em->getRepository('AppBundle:Movimientos')->findOneById($idMov);
        $estabilidadFiscal = $movimiento->getEstabilidadFiscal();
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                if ($form->get("estabilidadFiscal")->getData() === true) {
                    $movimiento->setEstabilidadFiscal(true);
                }
                $actividad->setMovimiento($movimiento);
                $em->persist($actividad);
                foreach ($actividad->getPlantaciones() as $key => $actividad_plantacion) {
                    $actividad_plantacion->setActividad($actividad);
                }
                $em->flush();
                $this->get('session')->getFlashBag()->add('notice', array('type' => 'success', 'title' => '', 'message' => 'Actividad creada satisfactoriamente.'));
                return $this->redirectToRoute('list_actividades', array('id'=>$idExp,'idMov'=>$idMov,'idAct' => $actividad->getId()));
            } catch (\Doctrine\ORM\ORMException $e) {
                $this->get('session')->getFlashBag()->add('error', 'Ocurrió un error al crear la actividad');
                $this->get('logger')->error($e->getMessage());
                return $this->redirectToRoute('list_movimientos', array('id' => $idExp, 'idMov' => $movimiento->getId()));
            }
        }

        return $this->render('actividades/new.html.twig', array(
          'actividade' => $actividad,
          'estabilidadFiscal' => $estabilidadFiscal,
          'form' => $form->createView(),
      ));
    }
    /**
     * Finds and displays a Actividades entity.
     *
     * @Route("/expedientes/{id}/movimientos/{idMov}/actividades/{idAct}", name="list_actividades")
     * @Method("GET")
     */
    public function indexAction($id, $idMov, $idAct)
    {
        $em = $this->getDoctrine()->getManager();
        $actividades = $em->getRepository('AppBundle:Actividades')->findOneById($idAct);
        $deleteForm = $this->createDeleteForm($actividades);

        $dql_p   = "SELECT p as plantacion,
                    st_area(p.geom)/10000 as area
                    FROM AppBundle:Actividades a
                    JOIN AppBundle:ActividadesPlantaciones ap WITH a.id = ap.actividad
                    JOIN AppBundle:Plantaciones p WITH p.id = ap.plantacion
                    WHERE a.id=:id";
        $plantaciones = $em->createQuery($dql_p)->setParameters(array('id' => $idAct))->getResult(Query::HYDRATE_OBJECT);
        return $this->render('actividades/index.html.twig', array(
            'actividad' => $actividades,
            'plantaciones' => $plantaciones,
            'delete'=> $deleteForm->createView()
        ));
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

    /**
     * Finds and displays a Actividades entity.
     *
     * @Route("/expedientes/{id}/movimientos/{idMov}/actividades/{idAct}/mapa", name="map_actividades")
     * @Method("GET")
     */
    public function mapAction($id, $idMov, $idAct)
    {
        $em = $this->getDoctrine()->getManager();
        $actividades = $em->getRepository('AppBundle:Actividades')->findOneById($idAct);
        $deleteForm = $this->createDeleteForm($actividades);

        $dql_p   = "SELECT   p.id as id,
          t.nombre as titular,
          e.nombreCientifico as especie,
          st_area(p.geom)/10000 as area,
          ST_AsGeoJson(ST_TRANSFORM(p.geom,4326)) as plantacion
                    FROM AppBundle:Actividades a
                    LEFT JOIN AppBundle:ActividadesPlantaciones ap WITH a.id = ap.actividad
                    LEFT JOIN AppBundle:Plantaciones p WITH p.id = ap.plantacion
                    LEFT JOIN AppBundle:Titulares t WITH p.titular = t.id
                    LEFT JOIN AppBundle:EspeciesPlantaciones ep WITH p.id = ep.plantacion
                    LEFT JOIN AppBundle:Especies e WITH ep.especie = e.id
                    WHERE a.id=:id";
        $plantaciones = $em->createQuery($dql_p)->setParameters(array('id' => $idAct))->getResult(Query::HYDRATE_OBJECT);
        $data = '';
        foreach ($plantaciones as $key => $plantacion) {
          $data[$key]['id']= $plantacion['id'];
          $data[$key]['type']= "Feature";
          $data[$key]['geometry']=json_decode($plantacion['plantacion']);
          $data[$key]['properties']['ID']=$plantacion['id'];
          $data[$key]['properties']['Titular']=$plantacion['titular'];
          $data[$key]['properties']['Especie']=$plantacion['especie'];
          $data[$key]['properties']['Superficie']=round($plantacion['area'],1);
        }
        return $this->render('map.html.twig', array('plantacion'=>json_encode($data)));
    }

    /**
     * Finds and edit a Actividad entity.
     *
     * @Route("/expedientes/{idExp}/movimientos/{idMov}/actividades/{id}/edit", name="edit_actividades")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Actividades $actividade, $idExp, $idMov)
    {
        $em = $this->getDoctrine()->getManager();
        $actividades_plantaciones = $em->getRepository('AppBundle:Actividades')->find($actividade->getId());

        if (!$actividades_plantaciones) {
            throw $this->createNotFoundException('No task found for id '.$id);
        }
        $originalActs = new ArrayCollection();

        foreach ($actividades_plantaciones->getPlantaciones() as $actividadPlantacion) {
            $originalActs->add($actividadPlantacion);
        }

        $editForm = $this->createForm('AppBundle\Form\ActividadesType', $actividade);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            foreach ($originalActs as $act) {
                if (false === $editForm->get('plantaciones')->getData()->contains($act)) {
                    $act->setActividad(null);
                    $em->persist($act);
                }
            }
            try {
                $this->getDoctrine()->getManager()->flush();
                $this->get('session')->getFlashBag()->add('notice', array('type' => 'success', 'title' => '', 'message' => 'Actividad actualizada satisfactoriamente.'));
                return $this->redirectToRoute('list_actividades', array('id'=>$idExp,'idMov'=>$idMov,'idAct' => $actividade->getId()));
            } catch (\Doctrine\ORM\ORMException $e) {
                $this->get('session')->getFlashBag()->add('error', 'Ocurrió un error al modificar la actividad');
                $this->get('logger')->error($e->getMessage());
                return $this->redirectToRoute('list_actividades', array('id'=>$idExp,'idMov'=>$idMov,'idAct' => $actividade->getId()));
            }
        }

        return $this->render('actividades/edit.html.twig', array(
            'actividade' => $actividade,
            'edit_form' => $editForm->createView(),
            //'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a actividade entity.
     *
     * @Route("/expedientes/{idExp}/movimientos/{idMov}/actividades/{id}", name="actividades_delete")
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
        return $this->redirectToRoute('list_movimientos', array('id'=>$actividade->getMovimiento()->getExpediente()->getId(), 'idMov'=>$actividade->getMovimiento()->getId()));
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
            ->setAction($this->generateUrl('actividades_delete', array('id' => $actividade->getId(),'idMov'=>$actividade->getMovimiento()->getId(),'idExp'=>$actividade->getMovimiento()->getExpediente()->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
