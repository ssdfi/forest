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
     * @Route("/", name="titulares_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $titulare = new Titulares();
        $search_form = $this->createForm('AppBundle\Form\TitularesType', $titulare);
        $search_form->handleRequest($request);

        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT a FROM AppBundle:Titulares a";
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $titulares = $paginator->paginate(
                $query,
                $request->query->getInt('page', 1),
                15,
                array('defaultSortFieldName' => 'a.nombre', 'defaultSortDirection' => 'asc')
            );
        return $this->render('titulares/index.html.twig',array('titulares' => $titulares, 'search_form'=>$search_form->createView()));

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

       if($param['nombre']){
          $nombre=$param['nombre'];
          $wheres[]="a.nombre = $nombre";
        }
        if($param['dni']){
           $dni=$param['dni'];
           $wheres[]="a.dni = $dni";
         }
        $titulare = new Titulares();
        //$search_form = $this->createForm('AppBundle\Form\TitularesType', $titulare);
        //$search_form->handleRequest($request);

        $titulares = $this->getDoctrine()->getRepository('AppBundle:Titulares');
        $query = $titulares->createQueryBuilder('p')
                ->where("p.nombre like :nombre")
                ->setParameter('nombre', '%'.$param['nombre'].'%')
                //->setParameter('partida', $partida)
                ->getQuery();
      $result=$query->getResult((\Doctrine\ORM\Query::HYDRATE_ARRAY));

      //$dql   = "SELECT a FROM AppBundle:Titulares a where a.nombre like '%tincho%'";
        if(!empty($wheres)){
          //$dql=implode("and",$wheres);
        }
        //dump($dql);
        //$query = $em->createQuery($dql);
      /*  $paginator = $this->get('knp_paginator');
        $titulares = $paginator->paginate(
                $query,
                $request->query->getInt('page', 1),
                15,
                array('defaultSortFieldName' => 'a.nombre', 'defaultSortDirection' => 'asc')
            );
      */
      //dump($result);
      //dump(json_encode($result));
      $response = new Response();
      $response->setContent(json_encode($result));
      $response->headers->set('Content-Type', 'application/json');

      return $response;
        //return $this->render('titulares/index.html.twig',array('titulares' => $titulares, 'search_form'=>$search_form->createView()));

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
            $em = $this->getDoctrine()->getManager();
            $em->persist($titulare);
            $em->flush();

            return $this->redirectToRoute('titulares_show', array('id' => $titulare->getId()));
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
            $em = $this->getDoctrine()->getManager();
            $em->persist($titulare);
            $em->flush();

            return $this->redirectToRoute('titulares_edit', array('id' => $titulare->getId()));
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
