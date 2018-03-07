<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Titulares;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ExpedientesSearchType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numeroInterno', TextType::class, array("attr"=> array("class"=>"form-control"),'required'=>false))
            ->add('numeroExpediente', TextType::class, array("attr"=> array("class"=>"form-control"),'required'=>false))
            ->add('zona', EntityType::class, array("attr"=> array("class"=>"form-control"),'class'=>'AppBundle\Entity\Zonas', 'required'=>false))
            ->add('anio', NumberType::class, array("attr"=> array("class"=>"form-control",'placeholder'=>"AAAA"),'required'=>false,'label'=>'Año'))
            ->add('fechaEntradaDesde', DateType::class, array('label'=>'Fecha entrada desde', 'widget'=>'single_text','format'=>'yyyy-MM-dd', 'attr'=>array('class' => 'form-control','placeholder'=>"AAAA-MM-DD"),'mapped'=>false))
            ->add('fechaEntradaHasta', DateType::class, array('label'=>'Fecha entrada hasta', 'widget'=>'single_text','format'=>'yyyy-MM-dd', 'attr'=>array('class' => 'form-control','placeholder'=>"AAAA-MM-DD"),'mapped'=>false))
            ->add('fechaSalidaDesde', DateType::class, array('label'=>'Fecha salida desde', 'widget'=>'single_text','required'=>false,'format'=>'yyyy-MM-dd', 'attr'=>array('class' => 'form-control','placeholder'=>"AAAA-MM-DD"),'mapped'=>false))
            ->add('fechaSalidaHasta', DateType::class, array('label'=>'Fecha salida hasta', 'widget'=>'single_text','required'=>false,'format'=>'yyyy-MM-dd', 'attr'=>array('class' => 'form-control','placeholder'=>"AAAA-MM-DD"),'mapped'=>false))
            ->add('responsable', EntityType::class, array("attr"=> array("class"=>"form-control"),'class'=>'AppBundle\Entity\Responsables','placeholder' => "",
                                                          'query_builder' => function ($er) {
                                                                              return $er->createQueryBuilder('u')
                                                                                  ->orderBy('u.activo', 'DESC');
                                                                          },
                                                          'group_by'=> function ($dato) {
                                                              if ($dato->getActivo() == true) {
                                                                  return 'Activos';
                                                              } else {
                                                                  return 'Inactivos';
                                                              }
                                                          },'mapped'=>false))
            ->add('tecnico', EntityType::class, array("attr"=> array("class"=>"form-control"),'class'=>'AppBundle\Entity\Tecnicos', 'required'=>false))
            ->add('validador', EntityType::class, array("attr"=> array("class"=>"form-control"),'class'=>'AppBundle\Entity\Responsables','placeholder' => "",'mapped'=>false ,
                                                        'query_builder' => function ($er) {
                                                                            return $er->createQueryBuilder('u')
                                                                                ->orderBy('u.activo', 'DESC');
                                                                        },
                                                        'group_by'=> function ($dato) {
                                                            if ($dato->getActivo() == false) {
                                                                return 'Inactivos';
                                                            } else {
                                                                return 'Activos';
                                                            }
                                                        }))
            ->add('activo', ChoiceType::class, array('choices'=>array('Todos'=>null,'Sí'=>true, 'No'=>false),"attr"=> array("class"=>"form-control"),'expanded'=>true, 'multiple'=>false,'empty_data'=>false))
            ->add('plurianual', ChoiceType::class, array('choices'=>array('Todos'=>null,'Sí'=>true, 'No'=>false),"attr"=> array("class"=>"form-control"),'expanded'=>true, 'multiple'=>false,'empty_data'=>false))
            ->add('agrupado', ChoiceType::class, array('choices'=>array('Todos'=>null,'Sí'=>true, 'No'=>false),"attr"=> array("class"=>"form-control"),'expanded'=>true, 'multiple'=>false,'empty_data'=>false))
            // ->add('pendiente', ChoiceType::class, array('choices'=>array('Todos'=>null,'Sí'=>true, 'No'=>false),"attr"=> array("class"=>"form-control"), 'expanded'=>true,'multiple'=>false,'empty_data'=>false, 'mapped'=>false))
            ->add('validado', ChoiceType::class, array('choices'=>array('Todos'=>null,'Sí'=>true, 'No'=>false),"attr"=> array("class"=>"form-control"),'expanded'=>true, 'multiple'=>false,'empty_data'=>false, 'mapped'=>false))
            ->add('estabilidad_fiscal', ChoiceType::class, array('choices'=>array('Todos'=>null,'Sí'=>true, 'No'=>false),"attr"=> array("class"=>"form-control"),'expanded'=>true, 'multiple'=>false,'empty_data'=>false, 'mapped'=>false))
            // ->add('incompleto', ChoiceType::class, array('choices'=>array('Todos'=>null,'Sí'=>true, 'No'=>false),"attr"=> array("class"=>"form-control"),'expanded'=>true, 'multiple'=>false,'empty_data'=>false, 'mapped'=>false))
            ->add('buscar', SubmitType::class, array('attr'=>array('class'=>'btn btn-primary pull-right')))
            ->add('exportar', SubmitType::class, array('attr'=>array('accept'=>".csv",'class'=>'btn btn-default'),'label'=>'Exportar a CSV'));
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
            'data_class' => 'AppBundle\Entity\Expedientes',
            'required' => false
        ));
    }
}
