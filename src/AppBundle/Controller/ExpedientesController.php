<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Expedientes;
use AppBundle\Entity\Titulares;
use AppBundle\Entity\ZonaDepartamentos;
use AppBundle\Form\ExpedientesType;
use AppBundle\Form\ExpedientesSearchType;
use Doctrine\ORM\Query;
use Symfony\Component\Validator\Constraints\DateTime;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\Common\Collections\ArrayCollection;

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
      $em = $this->getDoctrine()->getManager();

      $expediente = new Expedientes();
      $search_form = $this->createForm('AppBundle\Form\ExpedientesSearchType', $expediente, array(
        'action' => '/',
        'method' => 'get'
      ));
      $param=$request->query->get('expedientes_search');

      $wheres=array();

      if($param['numeroInterno']){
        $numeroInterno = $param['numeroInterno'];
        $wheres[]="lower(a.numeroInterno) like lower('%$numeroInterno%')";
      }
      if($param['numeroExpediente']){
         $numeroExpediente = $param['numeroExpediente'];
         $wheres[]="lower(a.numeroExpediente) like lower('%$numeroExpediente%')";
       }
      if($param['zona']){
        $zona = $param['zona'];
        $wheres[]="a.zona = $zona";
      }
      if($param['anio']){
        $anio = $param['anio'];
        $wheres[]="a.anio = $anio";
      }
      if($param['tecnico']){
        $tecnico = $param['tecnico'];
        $wheres[]="a.tecnico = $tecnico";
      }
      if($param['activo']){
        $activo = $param['activo'] == 1 ? 'TRUE' : 'FALSE';
        $wheres[]="a.activo = $activo";
      }
      if($param['plurianual']){
        $plurianual = $param['plurianual'] == 1 ? 'TRUE' : 'FALSE';
        $wheres[]="a.plurianual = $plurianual";
      }
      if($param['agrupado']){
        $agrupado = $param['agrupado'] == 1 ? 'TRUE' : 'FALSE';
        $wheres[]="a.agrupado = $agrupado";
      }

      if($param['responsable']){
        $responsable = $param['responsable'];
        $wheres[]="m.responsable = $responsable";
      }
      if($param['validador']){
        $validador = $param['validador'];
        $wheres[]="m.validador = $validador";
      }


      $dql   = "SELECT a FROM AppBundle:Expedientes a
                INNER JOIN AppBundle:Movimientos m WITH a.id = m.expediente";
      $filter = '';
      foreach ($wheres as $key => $value) {
        $filter = $filter .' '.$value;
        if(count($wheres) > 1 && $value != end($wheres)) {
          $filter = $filter .' AND';
        }
      }
      if(!empty($wheres)) {
        $dql = $dql .' WHERE '.$filter;
      }
      $query = $em->createQuery($dql);
      $paginator = $this->get('knp_paginator');
      $expedientes = $paginator->paginate(
              $query,
              $request->query->getInt('page', 1),
              15,
              array('defaultSortFieldName' => 'a.id', 'defaultSortDirection' => 'desc')
          );
      return $this->render('expedientes/list.html.twig',array('expedientes' => $expedientes, 'search_form'=>$search_form->createView()));
    }

    /**
     * Creates a new Expedientes entity.
     *
     * @Route("/expedientes/new", name="expedientes_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $expediente = new Expedientes();

        $form = $this->createForm('AppBundle\Form\ExpedientesType', $expediente);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          if($expediente->getTitulares()){
              foreach ($expediente->getTitulares() as $key => $array) {
                foreach ($array as $key => $titulares) {
                  foreach ($titulares as $key => $value) {
                    $titu= $em->getRepository('AppBundle:Titulares')->findOneBy(array('id'=>$value));
                    $expediente->addTitular($titu);
                  }
                }
              }
              unset($expediente->getTitulares()[0][0]);
            }

            $zona= $em->getRepository('AppBundle:Zonas')->findOneBy(array('codigo'=>$expediente->getZonaSplit()));
            if($zona != null){
                $expediente->setZona($zona);
                $zona_depto= $em->getRepository('AppBundle:ZonaDepartamentos')->findOneBy(array('zona'=>$expediente->getZonaSplit(),'codigo'=>$expediente->getZonaDeptoSplit()));
                if($zona_depto==null){
                }else {
                  $expediente->setZonaDepartamento($zona_depto);
                }
            }else{

            }
            $expediente->setAnio($expediente->getAnioSplit());

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
                  FROM AppBundle:Movimientos m
                  WHERE m.expediente=:id";
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
    public function editAction(Request $request, Expedientes $expediente_edit)
    {
        //$deleteForm = $this->createDeleteForm($expediente);
        $em = $this->getDoctrine()->getManager();
        $expediente = $em->getRepository('AppBundle:Expedientes')->findOneBy(array('id'=>$expediente_edit->getId()));

        $editForm = $this->createForm('AppBundle\Form\ExpedientesType', $expediente);

        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
          if($expediente->getTitulares()){
              foreach ($expediente->getTitulares() as $key => $array) {
                foreach ($array as $key => $titulares) {
                  $titu= $em->getRepository('AppBundle:Titulares')->findOneBy(array('id'=>$titulares));
                  $expediente->addTitular($titu);
                }
              }
              foreach ($expediente->getTitulares()[0] as $key => $value) {
                if (gettype($value) != "object"){
                  unset($expediente->getTitulares()[0][$key]);
                }
              }
            }
            $expediente->setUpdatedAt(new DateTime());

            try{
              $em->persist($expediente);
              $em->flush();
              $this->get('session')->getFlashBag()->add('notice', array('type' => 'success', 'title' => '', 'message' => 'Expediente actualizado satisfactoriamente.'));
              return $this->redirectToRoute('expedientes_show', array('id' => $expediente->getId()));

            } catch(\Doctrine\ORM\ORMException $e){
              $this->get('session')->getFlashBag()->add('error', 'Ocurrió un error al modificar el expediente');
              $this->get('logger')->error($e->getMessage());
              return $this->redirect('expedientes_show', array('id' => $expediente->getId()));
            }
            return $this->redirectToRoute('expedientes_show', array('id' => $expediente->getId()));
        }

        return $this->render('expedientes/edit.html.twig', array(
            'expediente' => $expediente,
            'edit_form' => $editForm->createView(),
            //'delete_form' => $deleteForm->createView(),
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
