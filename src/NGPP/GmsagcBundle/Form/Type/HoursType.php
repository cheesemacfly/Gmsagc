<?php

namespace NGPP\GmsagcBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('start', null, array('widget' => 'single_text'))
            ->add('end', null, array('widget' => 'single_text'))
            ->add('user', 'entity',
                    array('property' => 'username',
                        'disabled' => true,
                        'class' => 'NGPPGmsagcBundle:Users'))
            ->add('order', 'entity',
                    array('property' => 'id',
                        'disabled' => true,
                        'class' => 'NGPPGmsagcBundle:Orders'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NGPP\GmsagcBundle\Entity\Hours',
            'csrf_protection' => false
        ));
    }

    public function getName()
    {
        return 'ngpp_gmsagcbundle_hourstype';
    }
}
