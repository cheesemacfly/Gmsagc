<?php

namespace NGPP\GmsagcBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use NGPP\GmsagcBundle\Entity\PressRepository;
use NGPP\GmsagcBundle\Entity\Press;

class PressToTextTransformer implements DataTransformerInterface
{
    /**
     * @var PressRepository
     */
    private $repo;

    /**
     * @param PressRepository $em
     */
    public function __construct(PressRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Transforms an object (press) to a string (text).
     *
     * @param  Press|null $press
     * @return string
     */
    public function transform($press)
    {
        if (null === $press) {
            return "";
        }

        return $press->getName();
    }

    /**
     * Transforms a string (text) to an object (press).
     *
     * @param  string $text
     *
     * @return Press|null
     */
    public function reverseTransform($text)
    {
        if (!$text) {
            return null;
        }
        $press = $this->repo->findOneByName($text);

        if (null === $press) {
            $press = new Press();
            $press->setName($text);
        }

        return $press;
    }
}