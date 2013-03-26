<?php

namespace NGPP\GmsagcBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use NGPP\GmsagcBundle\Entity\Materials;

class MaterialToTextTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
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

        $material = $this->om
            ->getRepository('NGPPGmsagcBundle:Materials')
            ->findOneBy(array('name' => $text))
        ;

        if (null === $material) {
            $material = new Materials();
            $material->setName($text);
        }

        return $material;
    }
}