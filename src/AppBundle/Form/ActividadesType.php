<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


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
        ->add('plantaciones', CollectionType::class, array(
            'entry_type'    => ActividadesPlantacionesType::class,
            'allow_add'     => true,
            'allow_delete'  => true,
            'prototype'     => true,
            'label'         => false,
            'by_reference'  => false
          ))
        ;
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
