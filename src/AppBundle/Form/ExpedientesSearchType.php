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
            ->add('numeroInterno', TextType::class, array("attr"=> array("class"=>"form-group"),'required'=>false))
            ->add('numeroExpediente', TextType::class, array("attr"=> array("class"=>"form-group"),'required'=>false))
            ->add('zona',EntityType::class, array('class'=>'AppBundle\Entity\Zonas', 'required'=>false))
            ->add('anio', NumberType::class, array("attr"=> array("class"=>"form-group"),'required'=>false))
            ->add('anio', DateType::class, array(
                'widget' => 'choice',
            ))
            // fecha entrada desde
            // fecha entrada hasta
            // fecha salida desde
            // fecha salida hasta
            // responsable que es igual a validador
            ->add('tecnico',EntityType::class, array('class'=>'AppBundle\Entity\Tecnicos', 'required'=>false))
            //  validador que es igual a responsable
            ->add('activo',ChoiceType::class, array('choices'=>array('Todos'=>null,'Sí'=>true, 'No'=>false),"attr"=> array("class"=>"form-group"), 'multiple'=>false,'empty_data'=>false))
            ->add('plurianual',ChoiceType::class, array('choices'=>array('Todos'=>null,'Sí'=>true, 'No'=>false),"attr"=> array("class"=>"form-group"), 'multiple'=>false,'empty_data'=>false))
            ->add('agrupado',ChoiceType::class, array('choices'=>array('Todos'=>null,'Sí'=>true, 'No'=>false),"attr"=> array("class"=>"form-group"), 'multiple'=>false,'empty_data'=>false));
            // ->add('pendiente',ChoiceType::class, array('choices'=>array('Todos'=>null,'Sí'=>true, 'No'=>false),"attr"=> array("class"=>"form-group"), 'multiple'=>false,'empty_data'=>false))
            // ->add('validado',ChoiceType::class, array('choices'=>array('Todos'=>null,'Sí'=>true, 'No'=>false),"attr"=> array("class"=>"form-group"), 'multiple'=>false,'empty_data'=>false))
            // ->add('estabilidad_fiscal',ChoiceType::class, array('choices'=>array('Todos'=>null,'Sí'=>true, 'No'=>false),"attr"=> array("class"=>"form-group"), 'multiple'=>false,'empty_data'=>false))
            // ->add('incompleto',ChoiceType::class, array('choices'=>array('Todos'=>null,'Sí'=>true, 'No'=>false),"attr"=> array("class"=>"form-group"), 'multiple'=>false,'empty_data'=>false));

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