<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Especies;
use AppBundle\Form\EspeciesType;

/**
 * Especies controller.
 *
 * @Route("/especies")
 */
class EspeciesController extends Controller
{
    /**
     * Lists all Especies entities.
     *
     * @Route("/", name="especies_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $especies = $em->getRepository('AppBundle:Especies')->findAll();

        return $this->render('especies/index.html.twig', array(
            'especies' => $especies,
        ));
    }

    /**
     * Creates a new Especies entity.
     *
     * @Route("/new", name="especies_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $especy = new Especies();
        $form = $this->createForm('AppBundle\Form\EspeciesType', $especy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($especy);
            $em->flush();

            return $this->redirectToRoute('especies_show', array('id' => $especy->getId()));
        }

        return $this->render('especies/new.html.twig', array(
            'especy' => $especy,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Especies entity.
     *
     * @Route("/{id}", name="especies_show")
     * @Method("GET")
     */
    public function showAction(Especies $especy)
    {
        $deleteForm = $this->createDeleteForm($especy);

        return $this->render('especies/show.html.twig', array(
            'especy' => $especy,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Especies entity.
     *
     * @Route("/{id}/edit", name="especies_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Especies $especy)
    {
        $deleteForm = $this->createDeleteForm($especy);
        $editForm = $this->createForm('AppBundle\Form\EspeciesType', $especy);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($especy);
            $em->flush();

            return $this->redirectToRoute('especies_edit', array('id' => $especy->getId()));
        }

        return $this->render('especies/edit.html.twig', array(
            'especy' => $especy,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Especies entity.
     *
     * @Route("/{id}", name="especies_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Especies $especy)
    {
        $form = $this->createDeleteForm($especy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($especy);
            $em->flush();
        }

        return $this->redirectToRoute('especies_index');
    }

    /**
     * Creates a form to delete a Especies entity.
     *
     * @param Especies $especy The Especies entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Especies $especy)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('especies_delete', array('id' => $especy->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
