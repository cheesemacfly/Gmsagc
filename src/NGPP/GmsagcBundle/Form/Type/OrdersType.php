<?php

namespace NGPP\GmsagcBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OrdersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('relations', 'collection', array(
            'type' => new RelationsType(),
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,));
        $builder
            ->add('oral', null, array('widget' => 'single_text'))
            ->add('written', null, array('widget' => 'single_text'))
            ->add('observation')
            ->add('trial', null, array('widget' => 'single_text'))
            ->add('quote')
            ->add('pieces')
            ->add('shrinkage')
            ->add('press', 'press_selector', array('attr' => array('autocomplete' => 'off')))
            ->add('material', 'material_selector', array('attr' => array('autocomplete' => 'off')))
            ->add('action', 'entity',
                    array('property' => 'name',
                        'class' => 'NGPPGmsagcBundle:Actions'))
            ->add('mold', 'entity',
                    array('property' => 'name',
                        'class' => 'NGPPGmsagcBundle:Molds'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NGPP\GmsagcBundle\Entity\Orders'
        ));
    }

    public function getName()
    {
        return 'ngpp_gmsagcbundle_orderstype';
    }
}
