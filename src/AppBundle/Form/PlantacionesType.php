<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class PlantacionesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $nombre='';
        $builder
            //->add('titular')
            ->add('anioPlantacion',TextType::class,array('label'=>'Año Plantación'))
            ->add('tipoPlantacion',EntityType::class, array('class'=>'AppBundle\Entity\TiposPlantacion', 'placeholder' => "Seleccione una opción" ))
            ->add('nomenclaturaCatastral')
            ->add('estadoPlantacion',EntityType::class, array('class'=>'AppBundle\Entity\EstadosPlantacion', 'placeholder' => "Seleccione una opción" ))
            ->add('distanciaPlantas')
            ->add('cantidadFilas')
            ->add('distanciaFilas')
            ->add('densidad')
            ->add('fuenteInformacion',EntityType::class, array('class'=>'AppBundle\Entity\FuentesInformacion', 'placeholder' => "Seleccione una opción" ))
            ->add('anioInformacion',TextType::class,array('label'=>'Año Información'))
            ->add('fuenteImagen',EntityType::class, array('class'=>'AppBundle\Entity\FuentesImagen', 'placeholder' => "Seleccione una opción" ))
            ->add('fechaImagen', DateType::class, array('widget' => 'single_text','attr' => ['class' => 'js-datepicker']))
            ->add('baseGeometricaId',EntityType::class, array('class'=>'AppBundle\Entity\BasesGeometricas', 'placeholder' => "Seleccione una opción" ))
            //->add('provincia',EntityType::class, array('class'=>'AppBundle\Entity\Provincias','placeholder' => "Seleccione una opción"))
            //->add('departamento',EntityType::class, array('class'=>'AppBundle\Entity\Departamentos', 'placeholder' => "Seleccione una opción" ))
            ->add('estratoDesarrollo',EntityType::class, array('class'=>'AppBundle\Entity\EstratosDesarrollo', 'placeholder' => "Seleccione una opción" ))
            ->add('usoForestal')
            ->add('usoAnterior')
            ->add('objetivoPlantacion',EntityType::class, array('class'=>'AppBundle\Entity\ObjetivosPlantacion', 'placeholder' => "Seleccione una opción" ))
            ->add('activo',CheckboxType::class, array())
            ->add('comentarios')
            //historico nuevas plantaciones copiar datos activar nuevas..
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
