<?php

namespace NGPP\GmsagcBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('email')
            ->add('phone')
        ;
        $builder->add('addresses', 'collection', array(
            'type' => new AddressesType(),
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NGPP\GmsagcBundle\Entity\Contacts'
        ));
    }

    public function getName()
    {
        return 'ngpp_gmsagcbundle_contactstype';
    }
}
