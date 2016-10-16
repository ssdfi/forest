<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlantacionesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('anioPlantacion')
            ->add('nomenclaturaCatastral')
            ->add('distanciaPlantas')
            ->add('cantidadFilas')
            ->add('distanciaFilas')
            ->add('densidad')
            ->add('anioInformacion')
            //->add('fechaImagen', 'date')
            ->add('activo')
            ->add('comentarios')
            ->add('mpfId')
            ->add('unificadoId')
            //->add('createdAt', 'datetime')
            //->add('updatedAt', 'datetime')
            ->add('geom')
            ->add('baseGeometricaId')
            ->add('error')
            ->add('estadoPlantacion')
            ->add('estratoDesarrollo')
            ->add('fuenteImagen')
            ->add('fuenteInformacion')
            ->add('objetivoPlantacion')
            ->add('tipoPlantacion')
            ->add('titular')
            ->add('usoAnterior')
            ->add('usoForestal')
            ->add('provincia')
            ->add('departamento')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Plantaciones'
        ));
    }
}
