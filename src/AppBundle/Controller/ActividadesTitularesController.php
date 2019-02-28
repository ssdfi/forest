<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ActividadesTitulares;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Actividadestitulares controller.
 *
 *
 */
class ActividadesTitularesController extends Controller
{
    /**
    * Creates a new actividadesTitulare entity.
    *
    * @Route("/expedientes/{idExp}/movimientos/{idMov}/actividades/{idAct}/actividadesTitular/new", name="newActividadesTitulares")
    * @Method({"GET", "POST"})
    */

    public function newAction(Request $request, $idExp, $idMov, $idAct)
    {
        $actividadesTitulares = new Actividadestitulares();
        $form = $this->createForm('AppBundle\Form\ActividadesTitularesType', $actividadesTitulares);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            try {
                $actividadesTitulares->setActividad($em->getRepository('AppBundle:Actividades')->findOneById($idAct));
                $em->persist($actividadesTitulares);
                $em->flush($actividadesTitulares);
                $this->get('session')->getFlashBag()->add('notice', array('type' => 'success', 'title' => '', 'message' => 'Productor creado satisfactoriamente.'));
                return $this->redirectToRoute('list_actividades', array('id'=>$idExp, 'idMov'=> $idMov, 'idAct'=>$idAct));
            } catch (\Doctrine\ORM\ORMException $e) {
                $this->get('session')->getFlashBag()->add('error', 'Ocurrió un error al crear el productor');
                $this->get('logger')->error($e->getMessage());
                return $this->redirectToRoute('list_actividades', array('id'=>$idExp, 'idMov'=> $idMov, 'idAct'=>$idAct));
            }
        }

        return $this->render('actividadestitulares/new.html.twig', array(
        'actividadesTitulare' => $actividadesTitulares,
        'form' => $form->createView(),
      ));
    }
    /**
     * Lists all actividadesTitulare entities.
     *
     * @Route("/expedientes/{idExp}/movimientos/{idMov}/actividades/{idAct}/actividadesTitular/", name="actividadestitulares_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $actividadesTitulares = $em->getRepository('AppBundle:ActividadesTitulares')->findAll();

        return $this->render('actividadestitulares/index.html.twig', array(
            'actividadesTitulares' => $actividadesTitulares,
        ));
    }


    /**
     * Finds and displays a actividadesTitulare entity.
     *
     * @Route("/expedientes/{idExp}/movimientos/{idMov}/actividades/{idAct}/actividadesTitular/{id}", name="actividadestitulares_show")
     * @Method("GET")
     */
    public function showAction(ActividadesTitulares $actividadesTitulare)
    {
        $deleteForm = $this->createDeleteForm($actividadesTitulare);

        return $this->render('actividadestitulares/show.html.twig', array(
            'actividadesTitulare' => $actividadesTitulare,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing actividadesTitulare entity.
     *
     * @Route("/expedientes/{idExp}/movimientos/{idMov}/actividades/{idAct}/actividadesTitular/{id}/edit", name="actividadestitulares_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction($idExp, $idMov, $idAct, $id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $actividadesTitulares = $em->getRepository('AppBundle:ActividadesTitulares')->findOneById($id);
        $editForm = $this->createForm('AppBundle\Form\ActividadesTitularesType', $actividadesTitulares);
        $editForm->handleRequest($request);
        $generos = $em->getRepository('AppBundle:Generos')->findAll();

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            try {
                $this->getDoctrine()->getManager()->flush();
                $this->get('session')->getFlashBag()->add('notice', array('type' => 'success', 'title' => '', 'message' => 'Productor actualizado satisfactoriamente.'));
                return $this->redirectToRoute('list_actividades', array('id'=>$idExp, 'idMov'=> $idMov, 'idAct'=>$idAct));
            } catch (\Doctrine\ORM\ORMException $e) {
                $this->get('session')->getFlashBag()->add('error', 'Ocurrió un error al modificar el productor');
                $this->get('logger')->error($e->getMessage());
                return $this->redirectToRoute('list_actividades', array('id'=>$idExp, 'idMov'=> $idMov, 'idAct'=>$idAct));
            }
        }

        return $this->render('actividadestitulares/edit.html.twig', array(
            'actividadesTitulare' => $actividadesTitulares,
            'generos'=>$generos,
            'form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a actividadesTitulare entity.
     *
     * @Route("/expedientes/{idExp}/movimientos/{idMov}/actividades/{idAct}/actividadesTitular/{id}", name="actividadestitulares_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ActividadesTitulares $actividadesTitulare)
    {
        $form = $this->createDeleteForm($actividadesTitulare);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($actividadesTitulare);
            $em->flush($actividadesTitulare);
        }

        return $this->redirectToRoute('actividadestitulares_index');
    }

    /**
     * Creates a form to delete a actividadesTitulare entity.
     *
     * @param ActividadesTitulares $actividadesTitulare The actividadesTitulare entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ActividadesTitulares $actividadesTitulare)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('actividadestitulares_delete', array('id' => $actividadesTitulare->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
