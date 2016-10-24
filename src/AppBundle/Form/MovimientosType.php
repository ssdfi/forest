<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovimientosType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numeroFicha')
            ->add('anioInspeccion')
            ->add('fechaEntrada', 'date')
            ->add('fechaSalida', 'date')
            ->add('etapa')
            ->add('estabilidadFiscal')
            ->add('observacion')
            ->add('observacionInterna')
            ->add('auditar')
            ->add('destino')
            ->add('expediente')
            ->add('inspector')
            ->add('reinspector')
            ->add('responsable')
            ->add('validador')
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
