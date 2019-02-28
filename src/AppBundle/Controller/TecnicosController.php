<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Tecnicos;
use AppBundle\Form\TecnicosType;

use Doctrine\ORM\Query;

/**
 * Tecnicos controller.
 *
 * @Route("/tecnicos")
 */
class TecnicosController extends Controller
{
    /**
     * Lists all Tecnicos entities.
     *
     * @Route("", name="tecnicos_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $tecnico = new Tecnicos();
        $search_form = $this->createForm('AppBundle\Form\TecnicosType', $tecnico);
        $search_form->handleRequest($request);
        $param=$request->query->get('tecnico');

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
        if ($param['activo']) {
            $activo=$param['activo'];
            $wheres[]="a.activo = '$activo'";
        }

        $filter = '';
        foreach ($wheres as $key => $value) {
            $filter = $filter .' '.$value;
            if (count($wheres) > 1 && $value != end($wheres)) {
                $filter = $filter .' AND';
            }
        }

        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT a FROM AppBundle:Tecnicos a";
        if (!empty($wheres)) {
            $dql = $dql .' WHERE '.$filter;
        }
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $tecnicos = $paginator->paginate(
              $query,
              $request->query->getInt('page', 1),
              15,
              array('defaultSortFieldName' => 'a.nombre', 'defaultSortDirection' => 'asc')
          );

        return $this->render('tecnicos/index.html.twig', array('tecnicos' => $tecnicos, 'search_form' => $search_form->createView(),'param' => $param));
    }

    /**
     * Creates a new Tecnicos entity.
     *
     * @Route("/new", name="tecnicos_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tecnico = new Tecnicos();
        $form = $this->createForm('AppBundle\Form\TecnicosType', $tecnico);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($tecnico);
                $em->flush();
                $this->get('session')->getFlashBag()->add('notice', array('type' => 'success', 'title' => '', 'message' => 'Técnico creado satisfactoriamente.'));
                return $this->redirectToRoute('tecnicos_show', array('id' => $tecnico->getId()));
            } catch (\Doctrine\ORM\ORMException $e) {
                $this->get('session')->getFlashBag()->add('error', 'Ocurrió un error al crear el técnico');
                $this->get('logger')->error($e->getMessage());
                return $this->redirectToRoute('tecnicos_new');
            }
        }

        return $this->render('tecnicos/new.html.twig', array(
            'tecnico' => $tecnico,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Tecnicos entity.
     *
     * @Route("/{id}", name="tecnicos_show")
     * @Method("GET")
     */
    public function showAction(Tecnicos $tecnico, $id, Request $request)
    {
        $paginator = $this->get('knp_paginator');

        $em = $this->getDoctrine()->getManager();
        $dql_e   = "SELECT e
                FROM AppBundle:Tecnicos t
                JOIN AppBundle:Expedientes e WITH e.tecnico=t.id
                WHERE e.tecnico=:id";
        $query=$em->createQuery($dql_e)->setParameters(array('id' => $id))->getResult(Query::HYDRATE_OBJECT);

        $expedientes = $paginator->paginate(
              $query,
              $request->query->getInt('page', 1),
              15,
              array('defaultSortDirection' => 'desc')
          );
        $deleteForm = $this->createDeleteForm($tecnico);
        return $this->render('tecnicos/show.html.twig', array(
            'tecnico' => $tecnico,
            'expedientes' => $expedientes,
            'delete_form' => $deleteForm->createView(),
          ));
    }

    /**
     * Displays a form to edit an existing Tecnicos entity.
     *
     * @Route("/{id}/edit", name="tecnicos_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Tecnicos $tecnico)
    {
        $deleteForm = $this->createDeleteForm($tecnico);
        $editForm = $this->createForm('AppBundle\Form\TecnicosType', $tecnico);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($tecnico);
                $em->flush();
                $this->get('session')->getFlashBag()->add('notice', array('type' => 'success', 'title' => '', 'message' => 'Técnico editado satisfactoriamente.'));
                return $this->redirectToRoute('tecnicos_show', array('id' => $tecnico->getId()));
            } catch (\Doctrine\ORM\ORMException $e) {
                $this->get('session')->getFlashBag()->add('error', 'Ocurrió un error al editar el técnico');
                $this->get('logger')->error($e->getMessage());
                return $this->redirectToRoute('tecnicos_edit', array('id' => $tecnico->getId()));
            }
        }

        return $this->render('tecnicos/edit.html.twig', array(
            'tecnico' => $tecnico,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Tecnicos entity.
     *
     * @Route("/{id}", name="tecnicos_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Tecnicos $tecnico)
    {
        $form = $this->createDeleteForm($tecnico);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
              $em = $this->getDoctrine()->getManager();
              $em->remove($tecnico);
              $em->flush();
                $this->get('session')->getFlashBag()->add('notice', array('type' => 'success', 'title' => '', 'message' => 'Se ha eliminado satisfactoriamente.'));
                return $this->redirectToRoute('tecnicos_index');
            } catch (\Doctrine\ORM\ORMException $e) {
                $this->get('session')->getFlashBag()->add('error', 'Ocurrió un error al eliminar');
                $this->get('logger')->error($e->getMessage());
                return $this->redirectToRoute('tecnicos_index');
            }
        }

    }

    /**
     * Creates a form to delete a Tecnicos entity.
     *
     * @param Tecnicos $tecnico The Tecnicos entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tecnicos $tecnico)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tecnicos_delete', array('id' => $tecnico->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
