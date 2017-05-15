<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Actividades;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Query;
use Symfony\Component\Validator\Constraints\DateTime;

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
  public function newAction(Request $request,$idExp,$idMov)
  {
      $actividad = new Actividades();
      $form = $this->createForm('AppBundle\Form\ActividadesType', $actividad);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {

          $em = $this->getDoctrine()->getManager();
          $movimiento = $em->getRepository('AppBundle:Movimientos')->findOneById($idMov);
          $actividad->setMovimiento($movimiento);
          $em->persist($actividad);
          foreach ($actividad->getPlantaciones() as $key => $actividad_plantacion) {
            $actividad_plantacion->setActividad($actividad);
          }
          $em->flush();
          return $this->redirectToRoute('list_actividades', array('id'=>$idExp,'idMov'=>$idMov,'idAct' => $actividad->getId()));
      }

      return $this->render('actividades/new.html.twig', array(
          'actividade' => $actividad,
          'form' => $form->createView(),
      ));
  }
  /**
   * Finds and displays a Actividades entity.
   *
   * @Route("/expedientes/{id}/movimientos/{idMov}/actividades/{idAct}", name="list_actividades")
   * @Method("GET")
   */
    public function indexAction($id, $idMov,$idAct)
    {
        $em = $this->getDoctrine()->getManager();

        $actividades = $em->getRepository('AppBundle:Actividades')->findOneById($idAct);

        $dql_p   = "SELECT p
                    FROM AppBundle:Actividades a
                    JOIN AppBundle:ActividadesPlantaciones ap WITH a.id = ap.actividad
                    JOIN AppBundle:Plantaciones p WITH p.id = ap.plantacion
                    WHERE a.id=:id";
        $plantaciones = $em->createQuery($dql_p)->setParameters(array('id' => $idAct))->getResult(Query::HYDRATE_OBJECT);

        return $this->render('actividades/index.html.twig', array(
            'actividad' => $actividades,
            'plantaciones' => $plantaciones
        ));
    }

    /**
     * Finds and displays a actividade entity.
     *
     * @Route("/{id}", name="actividades_show")
     * @Method("GET")
     */
    public function showAction(Actividades $actividade)
    {
        $deleteForm = $this->createDeleteForm($actividade);

        return $this->render('actividades/show.html.twig', array(
            'actividade' => $actividade,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and edit a Actividad entity.
     *
     * @Route("/expedientes/{id}/movimientos/{idMov}/actividades/{idAct}/edit", name="edit_actividades")
     * @Method("GET")
     */
    public function editAction(Request $request, Actividades $actividade)
    {
        $deleteForm = $this->createDeleteForm($actividade);
        $editForm = $this->createForm('AppBundle\Form\ActividadesType', $actividade);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('actividades_edit', array('id' => $actividade->getId()));
        }

        return $this->render('actividades/edit.html.twig', array(
            'actividade' => $actividade,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a actividade entity.
     *
     * @Route("/{id}", name="actividades_delete")
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

        return $this->redirectToRoute('actividades_index');
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
            ->setAction($this->generateUrl('actividades_delete', array('id' => $actividade->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
