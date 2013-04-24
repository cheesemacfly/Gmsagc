<?php

namespace NGPP\GmsagcBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ExpensesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('order', 'entity',
                    array('property' => 'id',
                        'class' => 'NGPPGmsagcBundle:Orders',
                        'disabled' => true))
            ->add('description')
            ->add('price')
            ->add('observation')
            ->add('created', null, array('widget' => 'single_text'))
            ->add('contact', 'entity',
                    array('property' => 'name',
                        'class' => 'NGPPGmsagcBundle:Contacts'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NGPP\GmsagcBundle\Entity\Expenses'
        ));
    }

    public function getName()
    {
        return 'ngpp_gmsagcbundle_expensestype';
    }
}
