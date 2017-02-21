<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Titulares;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ExpedientesType extends AbstractType
{


    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numeroInterno', TextType::class, array("attr"=> array("class"=>"form-group")))
            ->add('numeroExpediente')
            ->add('tecnico',EntityType::class, array('class'=>'AppBundle\Entity\Tecnicos', 'placeholder' => "Seleccione una opción" ))
            ->add('plurianual')
            ->add('agrupado')
            ->add('activo')
            ->add('titulares',CollectionType::class,array(
              'entry_type'=>TitularesType::class,
              'allow_add'=>true,
              'prototype'=>true,
              'entry_options'=>array(
                'attr'=>array('class'=>'titular-box')
              )
            ));


/*
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function(FormEvent $event){
              $form=$event->getForm();
              $data=$event->getData();

              $expediente=$data->getTitulares();
              $titulares = null === $expedinet ? array() : $titulares->getTitularesDisponibles();
              dump($expediente);


              if(!$expediente || null === $expediente->getId()){
                //dump($expediente);
                //$form->add('titulares',CollectionType::class);
                /$form->add('titulares', EntityType::class, array(
                              'class' => 'AppBundle:Titulares'
                              //'multiple'=>true,
                              // 'required'=>false,
                              'choices'=> $titulares
                            ));

              }
          });
      */
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Expedientes'
        ));
    }
}
