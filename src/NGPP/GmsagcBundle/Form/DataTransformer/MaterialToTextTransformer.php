<?php

namespace NGPP\GmsagcBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use NGPP\GmsagcBundle\Entity\MaterialsRepository;
use NGPP\GmsagcBundle\Entity\Materials;

class MaterialToTextTransformer implements DataTransformerInterface
{
    /**
     * @var MaterialsRepository
     */
    private $repo;

    /**
     * @param MaterialsRepository $repo
     */
    public function __construct(MaterialsRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Transforms an object (material) to a string (text).
     *
     * @param  Materials|null $material
     * @return string
     */
    public function transform($material)
    {
        if (null === $material) {
            return "";
        }

        return $material->getName();
    }

    /**
     * Transforms a string (text) to an object (material).
     *
     * @param  string $text
     *
     * @return Materials|null
     */
    public function reverseTransform($text)
    {
        if (!$text) {
            return null;
        }
        $material = $this->repo->findOneByName($text);

        if (null === $material) {
            $material = new Materials();
            $material->setName($text);
        }

        return $material;
    }
}