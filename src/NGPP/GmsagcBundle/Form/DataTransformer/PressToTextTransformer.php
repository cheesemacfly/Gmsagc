<?php

namespace NGPP\GmsagcBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use NGPP\GmsagcBundle\Entity\Press;

class PressToTextTransformer implements DataTransformerInterface
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

        $press = $this->om
            ->getRepository('NGPPGmsagcBundle:Press')
            ->findOneByName($text)
        ;

        if (null === $press) {
            $press = new Press();
            $press->setName($text);
        }

        return $press;
    }
}