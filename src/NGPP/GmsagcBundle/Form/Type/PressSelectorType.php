<?php

namespace NGPP\GmsagcBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use NGPP\GmsagcBundle\Form\DataTransformer\PressToTextTransformer;
use NGPP\GmsagcBundle\Entity\PressRepository;

class PressSelectorType extends AbstractType
{
    /**
     * @var PressRepository
     */
    private $repo;

    /**
     * @param PressRepository $repo
     */
    public function __construct(PressRepository $repo)
    {
        $this->repo = $repo;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new PressToTextTransformer($this->repo);
        $builder->addModelTransformer($transformer);
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'press_selector';
    }
}
