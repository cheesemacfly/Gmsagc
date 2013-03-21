<?php

namespace NGPP\GmsagcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        $order = new Orders();
        
        //Edit mode
        if(!is_null($id))
            $order = $em->getRepository('NGPPGmsagcBundle:Orders')->find($id);
        
        $form = $this->createForm(new OrdersType(), $order);

        if ($this->getRequest()->isMethod('POST')) {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                
                $press = $em->getRepository('NGPPGmsagcBundle:Press')
                            ->findOneByName($order->getPress()->getName());                
                if($press != null && $press != $order->getPress())
                {
                    //prevent the old $order->getPress() to be updated
                    $em->detach($order->getPress());
                    $order->setPress($press);
                }
                else
                {
                    $em->persist($order->getPress());
                }
                
                $material = $em->getRepository('NGPPGmsagcBundle:Materials')
                                ->findOneByName($order->getMaterial()->getName());
                if($material != null && $material != $order->getMaterial())
                {
                    //prevent the old $order->getMaterial() to be updated
                    $em->detach($order->getMaterial());
                    $order->setMaterial($material);
                }
                else
                {
                    $em->persist($order->getMaterial());
                }
                
                $em->persist($order);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'The order has been saved!');
                
                return $this->redirect($this->generateUrl('ngpp_gmsagc_orders'));
            }
        }
        
        return $this->render('NGPPGmsagcBundle:Orders:save.html.twig',
                array('form' => $form->createView()));
    }
    
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository('NGPPGmsagcBundle:Orders')->find($id);

        if ($order)
        {
            $em->remove($order);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'The order has been deleted!');
        }
        else
            $this->get('session')->getFlashBag()->add('error', 'The order has not been deleted!');
        
        return $this->redirect($this->generateUrl('ngpp_gmsagc_orders'));
    }
}
