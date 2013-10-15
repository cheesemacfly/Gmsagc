<?php
namespace NGPP\GmsagcBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormInterface;

class SaveOrdersListener implements EventSubscriberInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param container ContainerInterface
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
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
        $action = is_null($data = $event->getData()) ? null : $data->getAction();
        $form = $event->getForm();

        //Does not allow change of the action when editing
        $this->addActionMenu($form, is_null($action) ?: false);
        $this->addMoldChoiceOrForm($form, is_null($action) ? null : $action->getId());
    }

    public function preSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $action_id = $data['action'];

        $form = $event->getForm();

        $this->addMoldChoiceOrForm($form, $action_id);
    }

    protected function addActionMenu(FormInterface $form, $isNew)
    {
        if($isNew)
            $form->add('action', 'entity', array('property' => 'name', 'class' => 'NGPPGmsagcBundle:Actions'));
        else
            $form->add('action', 'entity', array('property' => 'name', 'disabled' => true, 'class' => 'NGPPGmsagcBundle:Actions'));
    }

    protected function addMoldChoiceOrForm(FormInterface $form, $action_id)
    {
        switch($action_id)
        {
            case $this->container->getParameter('ngpp_gmsagc.actions')['modification']['id']:
            case $this->container->getParameter('ngpp_gmsagc.actions')['molding']['id']:
            case $this->container->getParameter('ngpp_gmsagc.actions')['reparation']['id']:
                $form->add('mold',
                        'entity',
                        array('property' => 'name', 'class' => 'NGPPGmsagcBundle:Molds'));
                break;
            //Allow Molds creation by default
            default:
                $form->add('mold',
                        $this->container->get('ngpp_gmsagc.form.molds'),
                        array('data_class' => 'NGPP\GmsagcBundle\Entity\Molds'));
        }
    }
}