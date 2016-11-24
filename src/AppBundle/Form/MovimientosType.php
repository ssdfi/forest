<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MovimientosType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numeroFicha',TextType::class, array('label'=>'Número de ficha'))
            ->add('inspector',EntityType::class, array('class'=>'AppBundle\Entity\Inspectores', 'placeholder' => "Seleccione una opción"))
            ->add('reinspector',EntityType::class, array('class'=>'AppBundle\Entity\Inspectores', 'placeholder' => "Seleccione una opción" ))
            ->add('responsable',EntityType::class, array('class'=>'AppBundle\Entity\Responsables', 'placeholder' => "Seleccione una opción" ))
            ->add('anioInspeccion',NumberType::class, array('label'=>'Año  de Inspección'))
            ->add('destino',EntityType::class, array('class'=>'AppBundle\Entity\Destinos', 'placeholder' => "Seleccione una opción" ))
            ->add('validador',EntityType::class, array('class'=>'AppBundle\Entity\Responsables', 'placeholder' => "Seleccione una opción" ))
            ->add('fechaEntrada',TextType::class, array('label'=>'Fecha entrada'))
            ->add('fechaSalida',TextType::class, array('label'=>'Fecha salida'))
            ->add('etapa')
            ->add('estabilidadFiscal')
            ->add('observacion')
            ->add('observacionInterna')
            ->add('auditar')
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
