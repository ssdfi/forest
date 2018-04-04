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
            ->add('numeroExpediente', TextType::class, array("attr"=> array("class"=>"form-group")))
            ->add('tecnico',EntityType::class, array('class'=>'AppBundle\Entity\Tecnicos' , 'required'=>false,'query_builder' => function ($er) {
                                return $er->createQueryBuilder('u')
                                    ->orderBy('u.nombre', 'asc');
                            },))
            ->add('plurianual',CheckboxType::class, array('attr' => array('data-label' => 'Plurianual'), 'label' => false, 'required'=>false))
            ->add('agrupado',CheckboxType::class, array('attr' => array('data-label' => 'Agrupado'), 'label' => false, 'required'=>false))
            ->add('activo',CheckboxType::class, array('attr' => array('data-label' => 'Activo'), 'label' => false, 'required'=>false));

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function(FormEvent $event){
              $form=$event->getForm();
              $data=$event->getData();
              if($data->getTitulares()){
                $titulares=$data->getTitulares()[0];
              }else{
                $titulares=[];
              }
              $form->add('titulares', ChoiceType::class, array(
                            'multiple'=>true,
                            'required'=>false,
                            'choices'=> $titulares,
                            'choice_label'=> 'nombre',
                            'choice_value'=>function($value){
                              if(get_class($value)=='AppBundle\Entity\Titulares'){
                                return ($value != null) ? $value->getId() : "";
                              }
                            },
                          ));
          });

          $builder->addEventListener(
              FormEvents::PRE_SUBMIT,
              function(FormEvent $event){
                $form=$event->getForm();
                $data=$event->getData();
                $titulares = null;
                if (array_key_exists('titulares', $data)) {
                  $titulares = $data['titulares'];
                }
                $form->add('titulares', ChoiceType::class, array(
                              'multiple'=>true,
                              'required'=>false,
                              'choices'=> $titulares,
                              'choice_value'=>function($value){
                                if((gettype($value)=="string")){
                                  return $value;
                                }
                              },
                            ));

            });

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
