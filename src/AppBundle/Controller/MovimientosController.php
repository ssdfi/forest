<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Movimientos;
use AppBundle\Entity\Expedientes;
use AppBundle\Form\MovimientosType;
use Doctrine;
use Doctrine\ORM\Query;
/**
 * Movimientos controller.
 *
 *
 */
class MovimientosController extends Controller
{

  /**
   * Creates a new Movimientos entity.
   *
   * @Route("/expedientes/{id}/movimientos/new", name="movimientos_new")
   * @Method({"GET", "POST"})
   */
  public function newAction(Request $request, $id)
  {
      $movimiento = new Movimientos();
      $form = $this->createForm('AppBundle\Form\MovimientosType', $movimiento);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $expediente = $em->getRepository('AppBundle:Expedientes')->findOneById($id);
          $movimiento->setExpediente($expediente);
          $em->persist($movimiento);
          $em->flush();

          return $this->redirectToRoute('list_movimientos', array('id'=>$id,'idMov' => $movimiento->getId()));
      }

      return $this->render('movimientos/new.html.twig', array(
          'movimiento' => $movimiento,
          'form' => $form->createView(),
      ));
  }
  /**
   * List Movimientos.
   *
   * @Route("/expedientes/{id}/movimientos/{idMov}", name="list_movimientos")
   * @Method("GET")
   */

    public function indexAction($id, $idMov)
    {
        $em = $this->getDoctrine()->getManager();

        $movimiento = $em->getRepository('AppBundle:Movimientos')->findOneById($idMov);
        $actividades = $em->getRepository('AppBundle:Actividades')->findByMovimiento($idMov);
        return $this->render('movimientos/index.html.twig', array(
            'expediente' => $id,
            'movimiento' => $movimiento,
            'actividades'=>$actividades
        ));
    }

    /**
     * Report Movimientos.
     *
     * @Route("/expedientes/{id}/movimientos/{idMov}/report", name="report_movimientos")
     * @Method("GET")
     */

      public function reportAction($id, $idMov)
      {
          $em = $this->getDoctrine()->getManager();
          $movimiento = $em->getRepository('AppBundle:Movimientos')->findOneById($idMov);
          $actividades = $em->getRepository('AppBundle:Actividades')->findByMovimiento($idMov);
          $dql_p   = "SELECT SUM(ap.superficieRegistrada), IDENTITY(ap.actividad) as id, IDENTITY(p.titular), IDENTITY(p.tipoPlantacion), IDENTITY(ep.especie)
                      FROM AppBundle:ActividadesPlantaciones ap
                      INNER JOIN AppBundle:Plantaciones p WITH p.id = ap.plantacion
                      INNER JOIN AppBundle:Actividades a WITH a.id = ap.actividad
                      INNER JOIN AppBundle:Actividades act WITH ap.actividad = act.id
                      JOIN AppBundle:EspeciesPlantaciones ep WITH p.id = ep.plantacion
                      WHERE a.movimiento = :id
                      GROUP BY ap.actividad, p.titular, p.tipoPlantacion, ep.especie
                      ORDER BY ap.actividad DESC ";
          $plantaciones = $em->createQuery($dql_p)->setParameters(array('id' => $idMov))->getResult(Query::HYDRATE_OBJECT);
          return $this->render('movimientos/report.html.twig', array(
              'expediente' => $id,
              'movimiento' => $movimiento,
              'actividades' => $actividades,
              'plantaciones' => $plantaciones
          ));
      }

      public function getActividadAction($id){
        $em = $this->getDoctrine()->getManager();
        $actividad = $em->getRepository('AppBundle:Actividades')->findById($id);
        return $this->render('movimientos/data.html.twig', array(
            'data' => $actividad[0]->getTipoActividad()->getDescripcion()
        ));

      }
      public function getTitularAction($id){
        $em = $this->getDoctrine()->getManager();
        $titular = $em->getRepository('AppBundle:Titulares')->findById($id);
        return $this->render('movimientos/data.html.twig', array(
            'data' => $titular[0]->getNombre()
        ));
      }
      public function getTipoPlantacionAction($id){
        $em = $this->getDoctrine()->getManager();
        $actividad = $em->getRepository('AppBundle:TiposPlantacion')->findById($id);
        return $this->render('movimientos/data.html.twig', array(
            'data' => $actividad[0]->getDescripcion()
        ));
      }

      public function getEspecieAction($id){
        $em = $this->getDoctrine()->getManager();
        $especie = $em->getRepository('AppBundle:Especies')->findById($id);
        return $this->render('movimientos/data.html.twig', array(
            'data' => $especie[0]->getNombreCientifico()
        ));
      }
    /**
     * Displays a form to edit an existing Movimientos entity.
     *
     * @Route("/expedientes/{idExp}/movimientos/{idMov}/edit", name="movimientos_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $idExp, $idMov)
    {
        $em = $this->getDoctrine()->getManager();
        $movimiento = $em->getRepository('AppBundle:Movimientos')->findOneById($idMov);
        //$deleteForm = $this->createDeleteForm($movimiento);
        $editForm = $this->createForm('AppBundle\Form\MovimientosType', $movimiento);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($movimiento);
            $em->flush();

            return $this->redirectToRoute('list_movimientos', array('id' => $idExp, 'idMov' => $movimiento->getId()));
        }

        return $this->render('movimientos/edit.html.twig', array(
            'movimiento' => $movimiento,
            'edit_form' => $editForm->createView()
        ));
    }
    /**
     * Finds and displays a Movimientos entity.
     *
     * @Route("/{id_mov}", name="movimientos_show")
     * @Method("GET")
     */
    public function showAction(Expedientes $expediente, Movimientos $movimiento)
    {
        $deleteForm = $this->createDeleteForm($movimiento);

        return $this->render('movimientos/show.html.twig', array(
            'movimiento' => $movimiento,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Movimientos entity.
     *
     * @Route("/expedientes/{idExp}/movimientos/{id_mov}/delete", name="movimientos_delete")
     * @Method("DELETE")
     */
    public function deleteAction($id_mov, $idExp)
    {
        $form = $this->createDeleteForm($movimiento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($movimiento);
            $em->flush();
        }

        return $this->redirectToRoute('movimientos_index');
    }

    /**
     * Creates a form to delete a Movimientos entity.
     *
     * @param Movimientos $movimiento The Movimientos entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Movimientos $movimiento)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('movimientos_delete', array('id' => $movimiento->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
