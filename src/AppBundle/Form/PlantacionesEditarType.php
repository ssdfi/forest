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
use AppBundle\Form\DataTransformer\EspeciesToNumberTransformer;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\PlantacionesHistorico;
use Doctrine\ORM\EntityRepository;
use AppBundle\Form\EventListener\AddEspeciesListener;
use AppBundle\Form\EventListener\AddHistoricoListener;

class PlantacionesEditarType extends AbstractType
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new EspeciesToNumberTransformer($this->manager);
        $id_plantacion = $builder->getData() ? $builder->getData()->getId() : '';
        $ids='';
        foreach ($options['param'] as $key => $value) {
          $ids.=$value;
          $next = array_key_exists($key + 1, $options['param']);
          if ($next) {
              $ids.='-';
          }
        }
        $builder
            ->add('param', TextType::class, array('mapped'=> false, 'label' => 'Plantaciones', 'data' => $ids,'attr' => ['disabled' => 'disabled']))
            ->add('anioPlantacion', TextType::class, array('label'=>'Año de Plantación','required'=>false))
            ->add('tipoPlantacion', EntityType::class, array('class'=>'AppBundle\Entity\TiposPlantacion', 'placeholder' => "Seleccione una opción" ,'required'=>false))
            ->add('nomenclaturaCatastral', TextType::class, array('label'=>'Nomenclatura Catrastal','required'=>false))
            ->add('estadoPlantacion', EntityType::class, array('class'=>'AppBundle\Entity\EstadosPlantacion', 'placeholder' => "Seleccione una opción" , 'label'=> "Estado de Plantación",'required'=>false))
            ->add('distanciaPlantas', TextType::class, array('label'=>'Distancia entre Plantas','required'=>false))
            ->add('cantidadFilas', IntegerType::class, array('label'=>'Cantidad de Filas','required'=>false))
            ->add('distanciaFilas', TextType::class, array('label'=>'Distancia entre Filas','required'=>false))
            ->add('densidad')
            ->add('fuenteInformacion', EntityType::class, array('class'=>'AppBundle\Entity\FuentesInformacion', 'placeholder' => "Seleccione una opción", 'label'=>'Fuente de Información' ,'required'=>false))
            ->add('anioInformacion', IntegerType::class, array('label'=>'Año de Información','required'=>false))
            ->add('fuenteImagen', EntityType::class, array('class'=>'AppBundle\Entity\FuentesImagen', 'placeholder' => "Seleccione una opción" , 'label'=>'Fuente de Imagen','required'=>false))
            ->add('fechaImagen', DateType::class, array('widget' => 'single_text','attr' => ['class' => 'js-datepicker','placeholder'=>"AAAA-MM-DD"], 'label'=>'Fecha de Imagen','required'=>false))
            ->add('baseGeometricaId', EntityType::class, array('class'=>'AppBundle\Entity\BasesGeometricas', 'placeholder' => "Seleccione una opción" , 'label'=>'Base Geométrica','required'=>false ))
            ->add('provincia', EntityType::class, array('class'=>'AppBundle\Entity\Provincias','query_builder' => function (EntityRepository $er) {
                                                                                                                return $er->createQueryBuilder('p')
                                                                                                                    ->orderBy('p.nombre', 'ASC');
                                                                                                            },'choice_label' => 'nombre','placeholder' => "Seleccione una opción",'required'=>false))
            ->add('departamento', EntityType::class, array('class'=>'AppBundle\Entity\Departamentos', 'placeholder' => "Seleccione una opción",'required'=>false))
            ->add('estratoDesarrollo', EntityType::class, array('class'=>'AppBundle\Entity\EstratosDesarrollo', 'placeholder' => "Seleccione una opción" ,'required'=>false))
            ->add('usoForestal')
            ->add('usoAnterior')
            ->add($builder->create('especie', EntityType::class, array(
                          'class' =>  \AppBundle\Entity\Especies::class,
                          'multiple'=>true,
                          'required'=>false,
                          'compound'=>false,
                          'query_builder' => function (EntityRepository $er) use ($id_plantacion) {
                              return $er->createQueryBuilder('u')
                              ->leftJoin('u.plantacion', 'p')
                              ->where('p.id = :id_plantacion')
                              ->setParameter('id_plantacion', $id_plantacion);
                          },
                          'choice_value'=>function ($data) {
                              return $data->getId();
                          },
                      )))
            ->add('objetivoPlantacion', EntityType::class, array('class'=>'AppBundle\Entity\ObjetivosPlantacion', 'placeholder' => "Seleccione una opción" ,'required'=>false))
            ->add('activo', CheckboxType::class, array('attr' => array('data-label' => 'Activo'), 'label' => false, 'required'=>false))
            ->add('comentarios');
        $builder->addEventSubscriber(new AddEspeciesListener())->addModelTransformer($transformer);

        $builder->addEventListener(FormEvents::PRE_SET_DATA,
              function (FormEvent $event) {
                  $form=$event->getForm();
                  $data=$event->getData();
                  if ($data->getTitular()) {
                      $titular= $data->getTitular();
                  } else {
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

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $form=$event->getForm();
            $data=$event->getData();
            if ($data->getHistorico()) {
                $choices = array();
                foreach ($data->getHistorico() as $key => $value) {
                    $choices[]=$value->getPlantacionNueva()->getId();
                }
            } else {
                $choices=[];
            }
            $form->add('plantacion_nuevas_ids', HiddenType::class, array(
                    'mapped' => false,
                  ));
        });
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $form=$event->getForm();
            $data=$event->getData();
            if ($data['plantacion_titular_id']){
              $titular = $this->manager->getRepository('AppBundle:Titulares')->findOneById($data['plantacion_titular_id']);
              $data['titular'] = $titular;
              $event->setData($data);
            }
        });

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $event->stopPropagation();
        }, 900);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'param' => null,
            'data_class' => 'AppBundle\Entity\Plantaciones'
        ));
    }
}
