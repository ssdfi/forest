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
            ->add('inspector',EntityType::class, array('class'=>'AppBundle\Entity\Inspectores', 'placeholder' => "Seleccione una opción",'required'=>false))
            ->add('reinspector',EntityType::class, array('class'=>'AppBundle\Entity\Inspectores', 'placeholder' => "Seleccione una opción" ,'required'=>false))
            ->add('responsable',EntityType::class, array('class'=>'AppBundle\Entity\Responsables','required'=>false,'placeholder' => "",
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
                                                          },'group_by'=> function($dato) { if ($dato->getActivo() == false) { return 'Inactivos'; } else { return 'Activos'; } }))
            ->add('anioInspeccion',TextType::class, array('label'=>'Año  de Inspección' ,'required'=>false))
            ->add('destino',EntityType::class, array('class'=>'AppBundle\Entity\Destinos', 'placeholder' => "Seleccione una opción" ,'required'=>false))
            ->add('validador',EntityType::class, array('class'=>'AppBundle\Entity\Responsables','required'=>false,'placeholder' => "",
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
                                                          },'group_by'=> function($dato) { if ($dato->getActivo() == false) { return 'Inactivos'; } else { return 'Activo'; } }))
            ->add('fechaEntrada',DateType::class, array('label'=>'Fecha entrada', 'widget'=>'single_text','format'=>'yyyy-MM-dd', 'attr'=>array('class' => 'form-control','placeholder'=>"AAAA-MM-DD")))
            ->add('fechaSalida',DateType::class, array('label'=>'Fecha salida', 'widget'=>'single_text','required'=>false,'format'=>'yyyy-MM-dd', 'attr'=>array('class' => 'form-control','placeholder'=>"AAAA-MM-DD")))
            ->add('etapa')
            ->add('estabilidadFiscal',CheckboxType::class, array('attr' => array('data-label' => 'Estabilidad Fiscal'), 'label' => false,'required'=>false))
            ->add('observacion')
            ->add('observacionInterna')
            ->add('auditar',CheckboxType::class, array('attr' => array('data-label' => 'Auditar'), 'label' => false,'required'=>false))
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
