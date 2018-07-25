<?php
// src/AppBundle/Form/EventListener/AddEspeciesListener.php
namespace AppBundle\Form\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

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

        if (true === $data->getPlantacionesNuevas()) {
            $form->add('plantacionesNuevas');
        }
    }

    public function onPreSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (!$data) {
            return;
        }
        if (array_key_exists('plantacionesNuevas', $data) && true == $data['plantacionesNuevas']) {
            $form->add('plantacionesNuevas');
        } else {
            unset($data['plantacionesNuevas']);
            $event->setData($data);
        }
    }
}
