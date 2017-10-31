<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormError;

class ActividadesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('tipoActividad',EntityType::class, array('class'=>'AppBundle\Entity\TiposActividad', 'placeholder' => "Seleccione una opción" ,'required'=>false))
        ->add('superficiePresentada')
        ->add('superficieCertificada')
        ->add('superficieInspeccionada')
        ->add('superficieRegistrada',TextType::class, array('disabled'=>true,'required'=>false))
        ->add('estabilidadFiscal', HiddenType::class, array('mapped'=>false))
        ->add('plantaciones', CollectionType::class, array(
            'entry_type'    => ActividadesPlantacionesType::class,
            'allow_add'     => true,
            'allow_delete'  => true,
            'prototype'     => true,
            'label'         => false,
            'by_reference'  => false
          ));
          $builder->addEventListener(
              FormEvents::PRE_SUBMIT,
              function(FormEvent $event){
                $form=$event->getForm();
                $data=$event->getData();
                $plantacion = $form->get('plantaciones');
                dump($plantacion);
                $form->get('plantaciones')->addError(new FormError('error message'));

            });
      /*
      function array_has_dupes($array) {
         // streamline per @Felix
         return count($array) !== count(array_unique($array));
      }
      */

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function(FormEvent $event){
              $form=$event->getForm();
              $data=$event->getData();

          });
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Actividades'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_actividades';
    }


}
