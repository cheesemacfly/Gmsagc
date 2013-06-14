<?php

namespace NGPP\GmsagcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \NGPP\GmsagcBundle\Entity\Relations;
use \NGPP\GmsagcBundle\Entity\Orders;
use \NGPP\GmsagcBundle\Form\Type\OrdersType;

class OrdersController extends Controller
{
    public function indexAction()
    {
        return $this->render('NGPPGmsagcBundle:Orders:index.html.twig',
                array('orders' => $this->getDoctrine()->getRepository('NGPPGmsagcBundle:Orders')->findAll()));
    }
    
    public function saveAction($id = null)
    {
        $em = $this->getDoctrine()->getManager();
        
        if(is_null($id) || is_null($order = $em->getRepository('NGPPGmsagcBundle:Orders')->find($id)))
        {
            $order = new Orders();
            
            $customer_relation = new Relations();
            $customer_type_id = $this->container->getParameter('ngpp_gmsagc_types')['customer'];
            $customer_relation->setType($em->getRepository('NGPPGmsagcBundle:Types')->findOneById($customer_type_id));
            $order->addRelations($customer_relation);
            
            $owner_relation = new Relations();
            $owner_type_id = $this->container->getParameter('ngpp_gmsagc_types')['owner'];
            $owner_relation->setType($em->getRepository('NGPPGmsagcBundle:Types')->findOneById($owner_type_id));
            $order->addRelations($owner_relation);
        }
        
        $form = $this->createForm($this->get('ngpp_gmsagc.form.orders'), $order);

        if ($this->getRequest()->isMethod('POST')) {
            
            if ($form->bind($this->getRequest())->isValid()) {
                
                $em->persist($order);
                $em->flush();
                
                //Update relations now that order_id is set
                foreach($order->getRelations() as $relation)
                {
                    $relation->setOrder($order);
                    
                    $em->persist($relation);
                }
                $em->flush();

                $this->get('session')->getFlashBag()->add('success',
                    $this->get('translator')->trans('orders.saved'));
                
                return $this->redirect($this->generateUrl('ngpp_gmsagc_orders'));
            }
        }
        
        return $this->render('NGPPGmsagcBundle:Orders:save.html.twig',
                array('form' => $form->createView()));
    }
    
    public function ajaxsaveAction()
    {
        $form = $this->createForm($this->get('ngpp_gmsagc.form.orders'), new Orders());
        $form->bind($this->getRequest());
        
        return $this->render('NGPPGmsagcBundle:Orders:save.html.twig',
                array('form' => $form->createView()));
    }
    
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository('NGPPGmsagcBundle:Orders')->find($id);

        if ($order)
        {
            foreach ($order->getRelations() as $relation) {
                $em->remove($relation);
            }
            
            $em->remove($order);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success',
                    $this->get('translator')->trans('orders.deleted'));
        }
        else
            $this->get('session')->getFlashBag()->add('error',
                    $this->get('translator')->trans('orders.nodeleted'));
        
        return $this->redirect($this->generateUrl('ngpp_gmsagc_orders'));
    }
}
