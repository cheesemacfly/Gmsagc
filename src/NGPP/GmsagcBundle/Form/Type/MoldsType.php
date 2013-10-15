<?php

namespace NGPP\GmsagcBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use NGPP\GmsagcBundle\Form\EventListener\SaveMoldsListener;

class MoldsType extends AbstractType
{
    private $SaveMoldsListener;
    
    function __construct(SaveMoldsListener $SaveMoldsListener)
    {
        $this->SaveMoldsListener = $SaveMoldsListener;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id')
            ->add('name')
            ->add('weight')
            ->add('place', 'places')
            ->add('shell')
        ;
        
        $builder->addEventSubscriber($this->SaveMoldsListener);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NGPP\GmsagcBundle\Entity\Molds'
        ));
    }

    public function getName()
    {
        return 'ngpp_gmsagcbundle_moldstype';
    }
}
