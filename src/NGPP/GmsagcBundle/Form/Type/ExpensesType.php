<?php

namespace NGPP\GmsagcBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ExpensesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('refOrder')
            ->add('description')
            ->add('price')
            ->add('observation')
            ->add('type')
            ->add('created')
            ->add('contact_id')
            ->add('order_id')
            ->add('contact')
            ->add('order')
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
