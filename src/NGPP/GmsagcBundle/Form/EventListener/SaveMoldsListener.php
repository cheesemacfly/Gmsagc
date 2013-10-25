<?php
namespace NGPP\GmsagcBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use NGPP\GmsagcBundle\Entity\MoldsRepository;

class SaveMoldsListener implements EventSubscriberInterface
{
    /**
     * @var MoldsRepository
     */
    private $repo;

    /**
     * @param repo MoldsRepository
     */
    public function __construct(MoldsRepository $repo)
    {
        $this->repo = $repo;
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
            $newMoldId = $this->repo->getNewId();
            $mold->setId($newMoldId);
        }
    }
}