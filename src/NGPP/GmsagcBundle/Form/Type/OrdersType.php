<?php

namespace NGPP\GmsagcBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use NGPP\GmsagcBundle\Form\EventListener\SaveOrdersListener;

class OrdersType extends AbstractType
{
    private $SaveOrdersListener;
    
    function __construct(SaveOrdersListener $SaveOrdersListener)
    {
        $this->SaveOrdersListener = $SaveOrdersListener;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('relations',
                'collection', 
                array(
                    'type' => new RelationsType(),
                    'label' => false,
                    'property_path' => 'relations'
                    ));
        $builder
            ->add('oral', null, array('widget' => 'single_text'))
            ->add('written', null, array('widget' => 'single_text'))
            ->add('observation')
            ->add('trial', null, array('widget' => 'single_text'))
            ->add('quote', 'money')
            ->add('pieces')
            ->add('shrinkage')
            ->add('press', 'press_selector', array('attr' => array('autocomplete' => 'off')))
            ->add('material', 'material_selector', array('attr' => array('autocomplete' => 'off')))
        ;

        $builder->addEventSubscriber($this->SaveOrdersListener);
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
