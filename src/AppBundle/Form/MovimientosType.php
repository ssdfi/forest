<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MovimientosType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      //fecha de entrada + inspector + responsable + Si el expediente es plurianual entonces tiene que tener si o si: ETAPA
        $builder
            ->add('numeroFicha',TextType::class, array('label'=>'Número de ficha','required'=>false))
            ->add('inspector',EntityType::class, array('class'=>'AppBundle\Entity\Inspectores', 'placeholder' => "Seleccione una opción"))
            ->add('reinspector',EntityType::class, array('class'=>'AppBundle\Entity\Inspectores', 'placeholder' => "Seleccione una opción" ,'required'=>false))
            ->add('responsable',EntityType::class, array('class'=>'AppBundle\Entity\Responsables', 'placeholder' => "Seleccione una opción" ))
            ->add('anioInspeccion',TextType::class, array('label'=>'Año  de Inspección' ,'required'=>false))
            ->add('destino',EntityType::class, array('class'=>'AppBundle\Entity\Destinos', 'placeholder' => "Seleccione una opción" ,'required'=>false))
            ->add('validador',EntityType::class, array('class'=>'AppBundle\Entity\Responsables', 'placeholder' => "Seleccione una opción" ,'required'=>false))
            ->add('fechaEntrada',DateType::class, array('label'=>'Fecha entrada', 'widget'=>'single_text'))
            ->add('fechaSalida',DateType::class, array('label'=>'Fecha salida', 'widget'=>'single_text','required'=>false))
            ->add('etapa')
            ->add('estabilidadFiscal',CheckboxType::class, array('attr' => array('data-label' => 'Estabilidad Fiscal'), 'label' => false))
            ->add('observacion')
            ->add('observacionInterna')
            ->add('auditar',CheckboxType::class, array('attr' => array('data-label' => 'Auditar'), 'label' => false))
            // agregar expediente en controlador
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Movimientos'
        ));
    }
}
