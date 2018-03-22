<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvents;
use AppBundle\Entity\Titulares;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Form\DataTransformer\TitularesToNumberTransformer;

class ActividadesTitularesType extends AbstractType
{
      private $manager;

      public function __construct(ObjectManager $manager) {
         $this->manager = $manager;
      }
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

      $transformer = new TitularesToNumberTransformer($this->manager);
        $builder
          ->add('tipoPlantacion',EntityType::class, array('class'=>'AppBundle\Entity\TiposPlantacion', 'placeholder' => "Seleccione una opción" ))
          // ->add('especie')
          ->add('superficiePresentada')
          ->add('superficieCertificada')
          ->add('superficieInspeccionada')
          ->add('observaciones',TextareaType::class,array('required'=>false,'attr' => array('class' => 'form-control')));

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
              FormEvents::PRE_SET_DATA,
              function(FormEvent $event){
                $form=$event->getForm();
                $data=$event->getData();
                if($data->getEspecie()){
                  $especie= $data->getEspecie();
                }else{
                  $especie = null;
                }
                $form->add('especie_id', HiddenType::class, array(
                              'data' => ($especie !== null) ? $especie->getId() : '',
                              'mapped' => false,
                ));
                $form->add('especie', TextType::class, array(
                              'data' => ($especie !== null) ? $especie->getCodigoSp() . '-' .$especie->getNombreCientifico() : '',
                              'required'=>true,
                              'attr' => ['disabled' => 'disabled'],
                ));
            });

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function(FormEvent $event){
              $form=$event->getForm();
              $data=$event->getData();
              if(array_key_exists('plantacion_titular_id',$data)){
                $titular = $this->manager->getRepository('AppBundle:Titulares')->findOneById($data['plantacion_titular_id']);
                $data['titular'] = $titular;
              }
              if(array_key_exists('especie_id',$data)){
                $especie = $this->manager->getRepository('AppBundle:Especies')->findOneById($data['especie_id']);
                $data['especie'] = $especie;
              }
              $event->setData($data);
          });

    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ActividadesTitulares'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_actividadestitulares';
    }


}
