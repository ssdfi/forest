<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Tecnico;
use AppBundle\Entity\Titulares;
use Doctrine\Common\Collections\ArrayCollection;

class ExpedientesController extends Controller{
    /**
     * @Route("/", name="list_expedientes")
     */
    public function listExpedientes(Request $request){
        $expedientes=$this->getDoctrine()->getRepository('AppBundle:Expedientes')->findAll();

        //$tecnico=$expedientes->getTecnico();
        //print_r($expedientes->getTecnico());
        return $this->render('expedientes/list.html.twig',
              array('expedientes'=>$expedientes));
    }
    /**
     * @Route("/expedientes/create", name="create_expedientes")
     */
    public function createExpedientes(Request $request){
        return $this->render('expedientes/create.html.twig');
    }
    /**
     * @Route("/expedientes/edit/{id}", name="edit_expedientes")
     */
    public function editExpedientes($id,Request $request){
        return $this->render('expedientes/edit.html.twig');
    }
    /**
     * @Route("/expedientes/view/{id}", name="view_expedientes")
     */
    public function viewExpedientes($id){
        return $this->render('expedientes/view.html.twig');
    }
}
