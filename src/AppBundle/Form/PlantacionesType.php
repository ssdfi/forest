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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Form\DataTransformer\PlantacionesHistoricoToNumberTransformer;

class PlantacionesType extends AbstractType
{

    private $manager;

    public function __construct(ObjectManager $manager) {
       $this->manager = $manager;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new PlantacionesHistoricoToNumberTransformer($this->manager);
        $builder
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
            ->add('copiarDatos',CheckboxType::class, array('attr' => array('data-label' => 'Copiar Datos'), 'mapped'=> false, 'label' => false, 'required'=>false))
            ->add('activarNuevas',CheckboxType::class, array('attr' => array('data-label' => 'Activar Nuevas'), 'mapped'=> false, 'label' => false, 'required'=>false));

            $builder->addEventListener(
              FormEvents::PRE_SET_DATA,
              function(FormEvent $event){
                $form=$event->getForm();
                $data=$event->getData();
                if($data->getTitular()){
                  $titular= $data->getTitular();
                }else{
                  $titular = null;
                }
                $form->add('plantacion_titular_id', HiddenType::class, array(
                  'data' => ($titular !== null) ? $titular->getId() : '',
                  'mapped' => false,
                ));
                $form->add('titular', TextType::class, array(
                  'data' => ($titular !== null) ? $titular->getNombre() : '',
                  'required'=>true,
                  'attr' => ['disabled' => 'disabled'],
                ));
            });

            $builder->addEventListener(
              FormEvents::PRE_SUBMIT,
              function(FormEvent $event){
                $form=$event->getForm();
                $data=$event->getData();
                $titular = $this->manager->getRepository('AppBundle:Titulares')->findOneById($data['plantacion_titular_id']);
                $data['titular'] = $titular;
                $event->setData($data);
            });

            $builder->addEventListener(
                FormEvents::PRE_SET_DATA,
                function(FormEvent $event){
                  $form=$event->getForm();
                  $data=$event->getData();
                  if($data->getHistorico()){
                    $choices = array();
                    foreach ($data->getHistorico() as $key => $value) {
                      $choices[]=$value->getPlantacionNueva()->getId();
                    }
                  }else{
                    $choices=[];
                  }
                  $form->add('historico', EntityType::class, array(
                                'class' => 'AppBundle:PlantacionesHistorico',
                                'multiple'=>true,
                                'required'=>true,
                                'choices'=> $choices,
                                'choice_value'=>function($value){
                                  return $value;
                                },
                            ));
              });


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
