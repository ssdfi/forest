<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Titulares;
use AppBundle\Form\TitularesType;
use Doctrine\ORM\Query;
use Symfony\Component\HttpFoundation\Response;

/**
 * Titulares controller.
 *
 * @Route("/titulares")
 */
class TitularesController extends Controller
{
    /**
     * Lists all Titulares entities.
     *
     * @Route("", name="titulares_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $titulare = new Titulares();
        $search_form = $this->createForm('AppBundle\Form\TitularesType', $titulare);
        $search_form->handleRequest($request);

        $param=$request->query->get('titulares');

        $wheres=array();

        if ($param['nombre']) {
          $nombre=$param['nombre'];
          foreach (explode(' ',$nombre) as $key => $value) {
            $wheres[]="lower(a.nombre) like lower('%$value%')";
          }
        }
        if ($param['dni']) {
            $dni=$param['dni'];
            $wheres[]="a.dni like '%$dni%'";
        }
        if ($param['cuit']) {
            $cuit=$param['cuit'];
            $wheres[]="a.cuit like '%$cuit%'";
        }
        $filter = '';
        foreach ($wheres as $key => $value) {
            $filter = $filter .' '.$value;
            if (count($wheres) > 1 && $value != end($wheres)) {
                $filter = $filter .' AND';
            }
        }
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT a FROM AppBundle:Titulares a";
        if (!empty($wheres)) {
            $dql = $dql .' WHERE '.$filter;
        }
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $titulares = $paginator->paginate(
                $query,
                $request->query->getInt('page', 1),
                15,
                array('defaultSortFieldName' => 'a.nombre', 'defaultSortDirection' => 'asc')
            );
        return $this->render('titulares/index.html.twig', array('titulares' => $titulares, 'search_form'=>$search_form->createView(),'param' => $param));
    }

    /**
     * Lists all Titulares entities.
     *
     * @Route("/json", name="titulares_search")
     * @Method("GET")
     */
    public function jsonAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $param=$request->query->get('titular');
        $wheres=array();

        if ($param['nombre']) {
            $nombre=$param['nombre'];
            foreach (explode(' ',$nombre) as $key => $value) {
              $wheres[]="lower(a.nombre) like lower('%$value%')";
            }
        }
        if ($param['dni']) {
            $dni=$param['dni'];
            $wheres[]="a.dni like '%$dni%'";
        }
        if ($param['cuit']) {
            $cuit=$param['cuit'];
            $wheres[]="a.cuit like '%$cuit%'";
        }
        $dql   = "SELECT a FROM AppBundle:Titulares a";
        $filter = '';
        foreach ($wheres as $key => $value) {
            $filter = $filter .' '.$value;
            if (count($wheres) > 1 && $value != end($wheres)) {
                $filter = $filter .' AND';
            }
        }
        if (!empty($wheres)) {
            $dql = $dql .' WHERE '.$filter;
        }

        $result = $em->createQuery($dql)
                      ->setMaxResults(50)
                      ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

        $response = new Response();
        $response->setContent(json_encode($result));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function getRequest()
    {
        return $this->container->get('request_stack')->getCurrentRequest();
    }
    /**
     * Creates a new Titulares entity.
     *
     * @Route("/new", name="titulares_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $titulare = new Titulares();
        $form = $this->createForm('AppBundle\Form\TitularesType', $titulare);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($titulare);
                $em->flush();
                $this->get('session')->getFlashBag()->add('notice', array('type' => 'success', 'title' => '', 'message' => 'Titular creado satisfactoriamente.'));
                return $this->redirectToRoute('titulares_show', array('id' => $titulare->getId()));
            } catch (\Doctrine\ORM\ORMException $e) {
                $this->get('session')->getFlashBag()->add('error', 'Ocurrió un error al crear el titular');
                $this->get('logger')->error($e->getMessage());
                return $this->redirectToRoute('titulares_new');
            }
        }

        return $this->render('titulares/new.html.twig', array(
            'titulare' => $titulare,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Titulares entity.
     *
     * @Route("/{id}", name="titulares_show")
     * @Method("GET")
     */
    public function showAction(Titulares $titular, $id)
    {
        $deleteForm = $this->createDeleteForm($titular);

        $em    = $this->get('doctrine.orm.entity_manager');

        $dql_b   = "SELECT e
                  FROM AppBundle:Plantaciones p
                  JOIN AppBundle:ActividadesPlantaciones ap WITH p.id=ap.plantacion
                  JOIN AppBundle:Actividades act WITH act.id=ap.actividad
                  JOIN AppBundle:Movimientos mov WITH mov.id=act.movimiento
                  JOIN AppBundle:Expedientes e WITH e.id=mov.expediente
                  WHERE p.titular=:id
                  AND e.agrupado=true";

        $productor_con_plantacion = $em->createQuery($dql_b)->setParameters(array('id' => $id))->getResult(Query::HYDRATE_OBJECT);


        $dql_c   = "SELECT e
                  FROM AppBundle:ActividadesTitulares actt
                  JOIN AppBundle:Actividades act WITH act.id=actt.actividad
                  JOIN AppBundle:Movimientos mov WITH mov.id=act.movimiento
                  JOIN AppBundle:Expedientes e WITH e.id=mov.expediente
                  LEFT JOIN AppBundle:ActividadesPlantaciones ap WITH ap.actividad = actt.actividad
                  WHERE actt.titular=:id";
        $productor_sin_plantacion = $em->createQuery($dql_c)->setParameters(array('id' => $id))->getResult(Query::HYDRATE_OBJECT);

        return $this->render('titulares/show.html.twig', array(
            'productor_con_plantacion' => $productor_con_plantacion,
            'productor_sin_plantacion' => $productor_sin_plantacion,
            'titular' => $titular,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Titulares entity.
     *
     * @Route("/{id}/edit", name="titulares_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Titulares $titulare)
    {
        $deleteForm = $this->createDeleteForm($titulare);
        $editForm = $this->createForm('AppBundle\Form\TitularesType', $titulare);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($titulare);
                $em->flush();
                $this->get('session')->getFlashBag()->add('notice', array('type' => 'success', 'title' => '', 'message' => 'Titular editado satisfactoriamente.'));
                return $this->redirectToRoute('titulares_show', array('id' => $titulare->getId()));
            } catch (\Doctrine\ORM\ORMException $e) {
                $this->get('session')->getFlashBag()->add('error', 'Ocurrió un error al editar el titular');
                $this->get('logger')->error($e->getMessage());
                return $this->redirectToRoute('titulares_new');
            }
        }

        return $this->render('titulares/edit.html.twig', array(
            'titulare' => $titulare,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Titulares entity.
     *
     * @Route("/{id}", name="titulares_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Titulares $titulare)
    {
        $form = $this->createDeleteForm($titulare);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($titulare);
            $em->flush();
        }

        return $this->redirectToRoute('titulares_index');
    }

    /**
     * Creates a form to delete a Titulares entity.
     *
     * @param Titulares $titulare The Titulares entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Titulares $titulare)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('titulares_delete', array('id' => $titulare->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
