<?php

namespace NGPP\GmsagcBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsersEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('email', 'email', array(
                'required' => false
            ))
            ->add('rate')
            ->add('groups', 'entity', array('property' => 'name',
                'expanded' => true,
                'multiple' => true,
                'class' => 'NGPPGmsagcBundle:Groups',
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NGPP\GmsagcBundle\Entity\Users'
        ));
    }

    public function getName()
    {
        return 'ngpp_gmsagcbundle_usersedittype';
    }
}
