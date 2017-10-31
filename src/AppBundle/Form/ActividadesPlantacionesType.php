<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Form\DataTransformer\PlantacionesToNumberTransformer;
use Symfony\Component\Form\FormError;

class ActividadesPlantacionesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    private $manager;

    public function __construct(ObjectManager $manager) {
       $this->manager = $manager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new PlantacionesToNumberTransformer($this->manager);
        $builder
          ->add('fecha',DateType::class, array('label' => false,'widget'=>'single_text','format' => 'yyyy-MM-dd','required'=>false,'attr' => array('class' => 'form-control','placeholder'=>"AAAA-MM-DD")))
          ->add('numeroPlantas',IntegerType::class, array('label'=>false,'required'=>false))
          ->add('superficieRegistrada',TextType::class,array('label' => false,'required'=>false,'attr' => array('class' => 'input-group')))
          ->add('estadoAprobacion',EntityType::class, array('class'=>'AppBundle\Entity\EstadosAprobacion','required'=>true,'label' => false))
          ->add('observaciones',TextareaType::class,array('label' => false,'required'=>false,'attr' => array('class' => 'form-control')));

         $builder->add(
            $builder->create('plantacion', IntegerType::class, array('label' => false,'required'=>true,'invalid_message' => 'La plantación {{ value }} no existe'))
                ->addModelTransformer($transformer)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ActividadesPlantaciones'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_actividadesplantaciones';
    }


}
