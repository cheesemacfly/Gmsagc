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
        
        //Determine if editing or creating
        $order = !is_null($id) && !is_null($order = $em->getRepository('NGPPGmsagcBundle:Orders')->find($id)) ? 
                $order : new Orders();
        
        $form = $this->createForm(new OrdersType(), $order);

        if ($this->getRequest()->isMethod('POST')) {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                
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
