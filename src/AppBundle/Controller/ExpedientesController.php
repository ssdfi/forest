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
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\Response;
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
          'method' => 'get',
          'user'=>$this->getUser()
        ));
        $param=($request->query->get('expedientes_search'))? $request->query->get('expedientes_search'):[];
        $dqql = $em->createQueryBuilder();
        $dqql->select('DISTINCT a, m.fechaEntrada, m.fechaSalida')
             ->from('AppBundle:Expedientes','a')
             ->leftJoin(
                          'AppBundle:Movimientos',
                          'm',
                          \Doctrine\ORM\Query\Expr\Join::WITH,
                          'a.id = m.expediente'
                      )
             ->where('a.numeroExpediente is not null');

        if(array_key_exists('numeroInterno',$param) && $param['numeroInterno']){
          $dqql->andwhere($dqql->expr()->like('UPPER(a.numeroInterno)', $dqql->expr()->literal('%'.strtoupper($param['numeroInterno']).'%')));
        }
        if(array_key_exists('numeroExpediente',$param) && $param['numeroExpediente']){
          $dqql->andwhere($dqql->expr()->like('UPPER(a.numeroExpediente)', $dqql->expr()->literal('%'.strtoupper($param['numeroExpediente']).'%')));
        }
        if(array_key_exists('zona',$param) && $param['zona']){
          $dqql->andwhere('a.zona ='.$param['zona']);
        }
        if(array_key_exists('anio',$param) && $param['anio']){
          $dqql->andwhere( $dqql->expr()->orX($dqql->expr()->eq('a.anio', $param['anio']),$dqql->expr()->eq('m.etapa', $param['anio'])));
        }
        if(array_key_exists('tecnico',$param) && $param['tecnico']){
          $dqql->andwhere('a.tecnico ='.$param['tecnico']);
        }
        if(array_key_exists('activo',$param) && $param['activo']){
          $activo = $param['activo'] == 1 ? 'TRUE' : 'FALSE';
          $dqql->andwhere('a.activo ='.$activo);
        }
        if(array_key_exists('plurianual',$param) && $param['plurianual']){
          $plurianual = $param['plurianual'] == 1 ? 'TRUE' : 'FALSE';
          $dqql->andwhere('a.plurianual ='.$plurianual);
        }
        if(array_key_exists('agrupado',$param) && $param['agrupado']){
          $agrupado = $param['agrupado'] == 1 ? 'TRUE' : 'FALSE';
          $dqql->andwhere('a.agrupado ='.$agrupado);
        }
        if(array_key_exists('responsable',$param) && $param['responsable']){
          $dqql->andwhere('m.responsable ='.$param['responsable']);
        }
        if(array_key_exists('validador',$param) && $param['validador']){
          $dqql->andwhere('m.validador ='.$param['validador']);
        }
        if(array_key_exists('fechaEntradaDesde',$param) && $param['fechaEntradaDesde']){
          $dqql->andwhere('m.fechaEntrada >= :fechaEntradaDesde');
          $dqql->setParameter('fechaEntradaDesde',$param['fechaEntradaDesde']);
        }
        if(array_key_exists('fechaEntradaHasta',$param) && $param['fechaEntradaHasta']){
          $dqql->andwhere('m.fechaEntrada >= :fechaEntradaDesde');
          $dqql->setParameter('fechaEntradaDesde',$param['fechaEntradaDesde']);
        }
        if(array_key_exists('fechaSalidaDesde',$param) && $param['fechaSalidaDesde']){
          $dqql->andwhere('m.fechaSalida >= :fechaSalidaDesde');
          $dqql->setParameter('fechaSalidaDesde',$param['fechaSalidaDesde']);
        }
        if (array_key_exists('fechaSalidaHasta',$param) && $param['fechaSalidaHasta']) {
          $dqql->andwhere('m.fechaSalida <= :fechaSalidaHasta');
          $dqql->setParameter('fechaSalidaHasta',$param['fechaSalidaHasta']);
        }
        if (array_key_exists('analizar',$param) && $param['analizar']) {
          $analizar = $param['analizar'] == 1 ? 'true' : 'false';
          if ($analizar == 'true') {
            $dqql->andwhere('m.fechaSalida is null');
          } else {
            $dqql->andwhere('m.fechaSalida is not null');
          }

        }
        if (array_key_exists('validado',$param) && $param['validado']) {
          $validado =$param['validado'] == 1 ? 'true' : 'false';
          if ($validado == 'true') {
            $dqql->andwhere('m.validador is not null');
          } else {
            $dqql->andwhere('m.validador is null');
          }
        }
        if (array_key_exists('estabilidad_fiscal',$param) && $param['estabilidad_fiscal']) {
          $estabilidad_fiscal = $param['estabilidad_fiscal'] == 1 ? 'true' : 'false';
          $dqql->andwhere('m.estabilidadFiscal ='.$estabilidad_fiscal);
        }

        if($this->isGranted('ROLE_USER') || $this->isGranted('ROLE_TECNICO_REGIONAL')) {
            $dqql->andwhere('m.fechaSalida is not null');
        }
        $paginator = $this->get('knp_paginator');
        $expedientes = $paginator->paginate(
              $dqql,
              $request->query->getInt('page',1),
              15,
              array('distinct' => true,'defaultSortFieldName' => 'a.updatedAt', 'defaultSortDirection' => 'desc')
          );
        $search_form->handleRequest($request);
        if ($search_form->has('exportar') && $search_form->get('exportar')->isClicked()) {
            return $this->render('expedientes/export.csv.twig', array('data' => $this->exportCSV($dqql)));
        }
        return $this->render('expedientes/list.html.twig', array('expedientes' => $expedientes, 'search_form'=>$search_form->createView(),'param' => $param));
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
            if ($expediente->getTitulares()) {
                foreach ($expediente->getTitulares() as $key => $array) {
                    foreach ($array as $key => $titulares) {
                        $titu= $em->getRepository('AppBundle:Titulares')->findOneBy(array('id'=>$titulares));
                        $expediente->addTitular($titu);
                        unset($expediente->getTitulares()[0][$key]);
                    }
                }
            }
            $zona= $em->getRepository('AppBundle:Zonas')->findOneBy(array('codigo'=>$expediente->getZonaSplit()));
            if ($zona != null) {
                $expediente->setZona($zona);
                $zona_depto= $em->getRepository('AppBundle:ZonaDepartamentos')->findOneBy(array('zona'=>$expediente->getZonaSplit(),'codigo'=>$expediente->getZonaDeptoSplit()));
                if ($zona_depto==null) {
                } else {
                    $expediente->setZonaDepartamento($zona_depto);
                }
            } else {
            }
            $expediente->setAnio($expediente->getAnioSplit());

            try {
                $em->persist($expediente);
                $em->flush();
                $this->get('session')->getFlashBag()->add('notice', array('type' => 'success', 'title' => '', 'message' => 'Expediente creado satisfactoriamente.'));
                return $this->redirectToRoute('expedientes_show', array('id' => $expediente->getId()));
            } catch (\Doctrine\ORM\ORMException $e) {
                $this->get('session')->getFlashBag()->add('error', 'Ocurrió un error al guardar los datos');
                $this->get('logger')->error($e->getMessage());
                return $this->redirect('expedientes_show', array('id' => $expediente->getId()));
            }
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
            if ($expediente->getTitulares()) {
                foreach ($expediente->getTitulares() as $key => $array) {
                    foreach ($array as $key => $titulares) {
                        $titu= $em->getRepository('AppBundle:Titulares')->findOneBy(array('id'=>$titulares));
                        $expediente->addTitular($titu);
                    }
                }
                foreach ($expediente->getTitulares()[0] as $key => $value) {
                    if (gettype($value) != "object") {
                        unset($expediente->getTitulares()[0][$key]);
                    }
                }
            }
            $expediente->setUpdatedAt(new DateTime());

            try {
                $em->persist($expediente);
                $em->flush();
                $this->get('session')->getFlashBag()->add('notice', array('type' => 'success', 'title' => '', 'message' => 'Expediente actualizado satisfactoriamente.'));
                return $this->redirectToRoute('expedientes_show', array('id' => $expediente->getId()));
            } catch (\Doctrine\ORM\ORMException $e) {
                $this->get('session')->getFlashBag()->add('error', 'Ocurrió un error al modificar el expediente');
                $this->get('logger')->error($e->getMessage());
                return $this->redirect('expedientes_show', array('id' => $expediente->getId()));
            }
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
     * @Route("/{id}/delete", name="expedientes_delete")
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

        return $this->redirectToRoute('list_expedientes');
    }
    /**
     * Export a CSV file.
     *
     * @param Expedientes $expediente The Expedientes entity
     *
     * @return \Symfony\Component\Form\Form The form
     * @Route("/expedientes.csv", name="expedientes_export")
     */
    public function exportCSV($dql)
    {
        $em = $this->getDoctrine()->getManager();
        $filename = 'expedientes';
        $filepath = $_SERVER["DOCUMENT_ROOT"] . $filename.'.csv';
        $output = fopen($filepath, 'w+');
        ob_end_clean();

        $fp = fopen('php://output', 'w');
        fputcsv($output, array('Número Interno', 'Número Expediente','Titular', 'Zona','Zona departamento','Técnico','Responsable'));
        $result = $em->createQuery($dql)->getResult();
        foreach ($result as $key => $value) {
            fputcsv($output, array($value[0]->getNumeroInterno(), $value[0]->getNumeroExpediente(), $value[0]->getTitularesGroup(), $value[0]->getZona()? $value[0]->getZona()->getDescripcion(): '', $value[0]->getZonaDepartamento()? $value[0]->getZonaDepartamento()->getDescripcion() : '',$value[0]->getTecnico()? $value[0]->getTecnico()->getNombre() : '',$value[0]->getResponsablesGroup()));
        }
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=expedientes.csv');
        readfile($filepath);
        exit();
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
