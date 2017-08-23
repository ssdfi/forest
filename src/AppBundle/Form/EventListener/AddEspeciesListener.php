<?php
namespace AppBundle\Form\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class AddEspeciesListener implements EventSubscriberInterface
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

        // Check whether the user from the initial data has chosen to
        // display his email or not.
        if (true === $data->getEspecie()) {
            $form->add('especie');
        }
    }

    public function onPreSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (!$data) {
            return;
        }

        // Check whether the user has chosen to display his email or not.
        // If the data was submitted previously, the additional value that
        // is included in the request variables needs to be removed.
        if (array_key_exists('especie', $data)) {
            $form->add('especie');
        } else {
            unset($data['especie']);
            $event->setData($data);
        }
    }
}
