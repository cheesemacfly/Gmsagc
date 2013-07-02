<?php

namespace NGPP\GmsagcBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Doctrine\ORM\EntityManager;
use NGPP\GmsagcBundle\Entity\Press;

class PressToTextTransformer implements DataTransformerInterface
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
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

        $press = $this->em
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