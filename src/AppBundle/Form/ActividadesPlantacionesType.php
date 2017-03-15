<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ActividadesPlantacionesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('plantacion',NumberType::class, array('label' => 'Plantación ID'))
          ->add('fecha',DateType::class, array('widget'=>'single_text','format' => 'yyyy-MM-dd HH:mm','attr' => array('class' => 'form-control')))
          ->add('numeroPlantas',NumberType::class, array('label'=>'Plantación ID'))
          ->add('superficieRegistrada',TextType::class,array('attr' => array('class' => 'form-control')))
          ->add('estadoAprobacion',EntityType::class, array('class'=>'AppBundle\Entity\EstadosAprobacion', 'placeholder' => "Seleccione una opción" ,'required'=>false))
          ->add('observaciones',TextareaType::class,array('attr' => array('class' => 'form-control')));
          //set actividad in controller
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ActividadesPlantaciones'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_actividadesplantaciones';
    }


}
