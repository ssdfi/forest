<?php
// src/AppBundle/Form/EventListener/AddEspeciesListener.php
namespace AppBundle\Form\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class AddHistoricoListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'onPreSetData',
            FormEvents::PRE_SUBMIT   => 'onPreSubmit',
        );
    }

    public function onPreSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();
        // if (true === $user->isShowEmail()) {
        //     $form->add('email', EmailType::class);
        // }
    }

    public function onPreSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();
        // $id_plantacion = $form->getViewData()->getId();

        if (!$data) {
            return;
        }

        if (array_key_exists('historico', $data) && true == $data['historico']) {
            $form->add('historico');
        } else {
            unset($data['historico']);
            $event->setData($data);
        }
    }
}
