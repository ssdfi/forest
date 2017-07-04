<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

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
            ->add('anioPlantacion',TextType::class,array('label'=>'Año de Plantación'))
            ->add('tipoPlantacion',EntityType::class, array('class'=>'AppBundle\Entity\TiposPlantacion', 'placeholder' => "Seleccione una opción" ))
            ->add('nomenclaturaCatastral',TextType::class,array('label'=>'Nomenclatura Catrastal'))
            ->add('estadoPlantacion',EntityType::class, array('class'=>'AppBundle\Entity\EstadosPlantacion', 'placeholder' => "Seleccione una opción" , 'label'=> "Estado de Plantación"))
            ->add('distanciaPlantas',TextType::class,array('label'=>'Distancia entre Plantas'))
            ->add('cantidadFilas',IntegerType::class,array('label'=>'Cantidad de Filas'))
            ->add('distanciaFilas',TextType::class,array('label'=>'Distancia entre Filas'))
            ->add('densidad')
            ->add('fuenteInformacion',EntityType::class, array('class'=>'AppBundle\Entity\FuentesInformacion', 'placeholder' => "Seleccione una opción", 'label'=>'Fuende de Información' ))
            ->add('anioInformacion',IntegerType::class,array('label'=>'Año de Información'))
            ->add('fuenteImagen',EntityType::class, array('class'=>'AppBundle\Entity\FuentesImagen', 'placeholder' => "Seleccione una opción" , 'label'=>'Fuente de Imagen'))
            ->add('fechaImagen', DateType::class, array('widget' => 'single_text','attr' => ['class' => 'js-datepicker'], 'label'=>'Fecha de Imagen'))
            ->add('baseGeometricaId',EntityType::class, array('class'=>'AppBundle\Entity\BasesGeometricas', 'placeholder' => "Seleccione una opción" , 'label'=>'Base Geométrica' ))
            //->add('provincia',EntityType::class, array('class'=>'AppBundle\Entity\Provincias','choice_label' => 'nombre','placeholder' => "Seleccione una opción"))
            //->add('departamento',EntityType::class, array('class'=>'AppBundle\Entity\Departamentos', 'placeholder' => "Seleccione una opción" ))
            ->add('estratoDesarrollo',EntityType::class, array('class'=>'AppBundle\Entity\EstratosDesarrollo', 'placeholder' => "Seleccione una opción" ))
            ->add('usoForestal')
            ->add('usoAnterior')
            ->add('objetivoPlantacion',EntityType::class, array('class'=>'AppBundle\Entity\ObjetivosPlantacion', 'placeholder' => "Seleccione una opción" ))
            ->add('activo',CheckboxType::class, array('attr' => array('data-label' => 'Activo'), 'label' => false, 'required'=>false))
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
