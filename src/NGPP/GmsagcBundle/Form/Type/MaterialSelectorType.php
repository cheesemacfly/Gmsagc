<?php

namespace NGPP\GmsagcBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use NGPP\GmsagcBundle\Form\DataTransformer\MaterialToTextTransformer;
use NGPP\GmsagcBundle\Entity\MaterialsRepository;

class MaterialSelectorType extends AbstractType
{
    /**
     * @var MaterialsRepository
     */
    private $repo;

    /**
     * @param MaterialsRepository $om
     */
    public function __construct(MaterialsRepository $repo)
    {
        $this->repo = $repo;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new MaterialToTextTransformer($this->repo);
        $builder->addModelTransformer($transformer);
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'material_selector';
    }
}
