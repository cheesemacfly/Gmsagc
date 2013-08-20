<?php
namespace NGPP\GmsagcBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityManager;

class SaveMoldsListener implements EventSubscriberInterface
{
    /**
     * @var EntityManager
     */
    private $em;
    
    /**
     * @param em EntityManager
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
        );
    }

    public function preSetData(FormEvent $event)
    {
        $mold = $event->getData();
        //Not editing an entity
        if(!is_null($mold) && is_null($mold->getId()))
        {
            $newMoldId = $this->em->getRepository('NGPPGmsagcBundle:Molds')->getNewId();
            $mold->setId($newMoldId);
        }
    }
}