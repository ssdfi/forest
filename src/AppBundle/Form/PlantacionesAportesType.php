<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlantacionesAportesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('idOrig')
        ->add('anioPlantacion')
        ->add('nomenclaturaCatastral')
        ->add('distanciaPlantas')
        ->add('cantidadFilas')
        ->add('distanciaFilas')
        ->add('densidad')
        ->add('anioInformacion')
        ->add('fechaImagen')
        ->add('activo')
        ->add('comentarios')
        ->add('mpfId')
        ->add('unificadoId')
        ->add('createdAt')
        ->add('updatedAt')
        ->add('geom')
        ->add('baseGeometricaId')
        ->add('usuario')
        ->add('accion')
        ->add('modificacion')
        ->add('objetivoPlantacion')
        ->add('fuenteInformacion')
        ->add('provincia')
        ->add('departamento')
        ->add('usoAnterior')
        ->add('error')
        ->add('fuenteImagen')
        ->add('estratoDesarrollo')
        ->add('tipoPlantacion')
        ->add('usoForestal')
        ->add('estadoPlantacion')
        ->add('titular')        ;

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\PlantacionesAportes'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_plantacionesaportes';
    }


}
