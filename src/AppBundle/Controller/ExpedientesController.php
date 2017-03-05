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

      $expedientes = new Expedientes();

      $search_form = $this->createFormBuilder($expedientes)
            ->add('numeroInterno', TextType::class, array("attr"=> array("class"=>"form-group"),'required'=>false))
            ->add('numeroExpediente', TextType::class, array("attr"=> array("class"=>"form-group"),'required'=>false))
            ->add('zona',EntityType::class, array('class'=>'AppBundle\Entity\Zonas', 'required'=>false))
            // anio etapa
            // fecha entrada desde
            // fecha entrada hasta
            // fecha salida desde
            // fecha salida hasta
            // responsable que es igual a validador
            ->add('tecnico',EntityType::class, array('class'=>'AppBundle\Entity\Tecnicos', 'required'=>false))
            //  validador que es igual a responsable
            ->add('activo',ChoiceType::class, array('choices'=>array('Todos'=>null,'Sí'=>true, 'No'=>false),"attr"=> array("class"=>"form-group"), 'multiple'=>false,'empty_data'=>false))
            ->add('plurianual',ChoiceType::class, array('choices'=>array('Todos'=>null,'Sí'=>true, 'No'=>false),"attr"=> array("class"=>"form-group"), 'multiple'=>false,'empty_data'=>false))
            ->add('agrupado',ChoiceType::class, array('choices'=>array('Todos'=>null,'Sí'=>true, 'No'=>false),"attr"=> array("class"=>"form-group"), 'multiple'=>false,'empty_data'=>false))
            // ->add('pendiente',ChoiceType::class, array('choices'=>array('Todos'=>null,'Sí'=>true, 'No'=>false),"attr"=> array("class"=>"form-group"), 'multiple'=>false,'empty_data'=>false))
            //->add('_validado',ChoiceType::class, array('choices'=>array('Todos'=>null,'Sí'=>true, 'No'=>false),"attr"=> array("class"=>"form-group"), 'multiple'=>false,'empty_data'=>false))
            //->add('_estabilidad_fiscal',ChoiceType::class, array('choices'=>array('Todos'=>null,'Sí'=>true, 'No'=>false),"attr"=> array("class"=>"form-group"), 'multiple'=>false,'empty_data'=>false))
            //->add('_incompleto',ChoiceType::class, array('choices'=>array('Todos'=>null,'Sí'=>true, 'No'=>false),"attr"=> array("class"=>"form-group"), 'multiple'=>false,'empty_data'=>false))

          ->getForm()->createView();

      //$search_form->handleRequest($request);

      $em    = $this->get('doctrine.orm.entity_manager');
      $dql   = "SELECT a FROM AppBundle:Expedientes a";
      $query = $em->createQuery($dql);
      $paginator = $this->get('knp_paginator');
      $expedientes = $paginator->paginate(
              $query,
              $request->query->getInt('page', 1),
              15,
              array('defaultSortFieldName' => 'a.id', 'defaultSortDirection' => 'desc')
          );
      return $this->render('expedientes/list.html.twig',array('expedientes' => $expedientes, 'search_form'=>$search_form));
    }

    /**
     * Creates a new Expedientes entity.
     *
     * @Route("/expedientes/new", name="expedientes_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        //dump($request);
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
            $expediente->setCreatedAt(new DateTime());
            $expediente->setUpdatedAt(new DateTime());
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
    public function editAction(Request $request, Expedientes $expediente)
    {
        $deleteForm = $this->createDeleteForm($expediente);
        $editForm = $this->createForm('AppBundle\Form\ExpedientesType', $expediente);
        dump($request);
        //$editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
          dump($this);
          dump($expediente);
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
            $expediente->setUpdatedAt(new DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($expediente);
            $em->flush();

            return $this->redirectToRoute('expedientes_edit', array('id' => $expediente->getId()));
        }

        return $this->render('expedientes/edit.html.twig', array(
            'expediente' => $expediente,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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
