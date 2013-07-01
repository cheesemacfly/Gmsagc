<?php

namespace NGPP\GmsagcBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use NGPP\GmsagcBundle\Form\EventListener\AddPasswordFieldSubscriber;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('email', 'email', array(
                'required' => false
            ))
            ->add('rate')
            ->add('resultsPerPage', 'choice', array('choices' => array(10 => 10, 20 => 20, 50 => 50, 100 => 100)))
            ->add('isActive')
            ->add('groups', 'entity', array('property' => 'name',
                'expanded' => true,
                'multiple' => true,
                'class' => 'NGPPGmsagcBundle:Groups',
                ))
        ;
        
        $builder->addEventSubscriber(new AddPasswordFieldSubscriber());
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NGPP\GmsagcBundle\Entity\Users'
        ));
    }

    public function getName()
    {
        return 'ngpp_gmsagcbundle_userstype';
    }
}
