<?php
namespace NGPP\GmsagcBundle\Form\EventListener;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\Common\Persistence\ObjectManager;

use NGPP\GmsagcBundle\Form\Type\MoldsType;

class SaveOrdersListener implements EventSubscriberInterface
{
    /**
     * @var FormFactoryInterface
     */
    private $factory;

    /**
     * @param factory FormFactoryInterface
     */
    public function __construct(FormFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SUBMIT => 'preSubmit',
            FormEvents::PRE_SET_DATA => 'preSetData',
        );
    }

    public function preSetData(FormEvent $event)
    {
        $action = $event->getData()->getAction();
        $builder = $event->getForm();

        $this->customizeForm($builder, is_null($action) ? null : $action->getId());
    }

    public function preSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $action_id = $data['action'];
        
        if ($action_id === null) {
            $msg = 'The action %s is not valid';
            throw new \Exception(sprintf($msg, $action_id));
        }
        $builder = $event->getForm();

        $this->customizeForm($builder, $action_id);
    }

    protected function customizeForm($builder, $action_id)
    {
        switch($action_id)
        {
            case 2:
                $builder->add('mold', 'entity', array('property' => 'name', 'class' => 'NGPPGmsagcBundle:Molds'));
                break;
            default:
                $builder->add('mold', new MoldsType(), array('data_class' => 'NGPP\GmsagcBundle\Entity\Molds'));
        }
    }
}