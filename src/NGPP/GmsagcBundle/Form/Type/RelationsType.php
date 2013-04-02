<?php

namespace NGPP\GmsagcBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RelationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', 'entity',
                    array('property' => 'name',
                        'class' => 'NGPPGmsagcBundle:Types'))
            ->add('contact', 'entity',
                    array('property' => 'name',
                        'class' => 'NGPPGmsagcBundle:Contacts'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NGPP\GmsagcBundle\Entity\Relations'
        ));
    }

    public function getName()
    {
        return 'ngpp_gmsagcbundle_relationstype';
    }
}
