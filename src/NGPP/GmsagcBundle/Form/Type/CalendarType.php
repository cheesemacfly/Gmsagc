<?php

namespace NGPP\GmsagcBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CalendarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('hours', 'collection', array('type' => new HoursType()))
        ;
    }

    public function getName()
    {
        return 'ngpp_gmsagcbundle_calendartype';
    }
}
