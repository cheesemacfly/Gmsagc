<?php

namespace NGPP\GmsagcBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

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
        $form = $event->getForm();

        // check if the user object is "new"
        // If you didn't pass any data to the form, the data is "null".
        // This should be considered a new "User"
        if (!$data || !$data->getId()) {
            $form->add('password', 'repeated', array(
                        'type' => 'password',
                        'invalid_message' => 'The password fields must match.',
                        'options' => array('attr' => array('class' => 'password-field')),
                        'required' => false,
                        'first_options'  => array('label' => 'Password'),
                        'second_options' => array('label' => 'Repeat Password')));
        }
    }
}