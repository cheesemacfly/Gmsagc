<?php

namespace NGPP\GmsagcBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use NGPP\GmsagcBundle\Form\Type\PasswordType;

class AddPasswordFieldSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        // Tells the dispatcher that you want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return array(FormEvents::PRE_SET_DATA => 'preSetData');
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $builder = $event->getForm();

        // check if the user object is "new"
        // If you didn't pass any data to the form, the data is "null".
        // This should be considered a new "User"
        if (!$data || !$data->getId()) {
            $builder->add('password', new PasswordType(), array(
                'label' => false,
                'data_class' => 'NGPP\GmsagcBundle\Entity\Users'
            ));
        }
    }
}