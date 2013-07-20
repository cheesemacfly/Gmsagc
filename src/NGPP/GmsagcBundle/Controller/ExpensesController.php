<?php

namespace NGPP\GmsagcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \NGPP\GmsagcBundle\Entity\Expenses;
use \NGPP\GmsagcBundle\Form\Type\ExpensesType;

class ExpensesController extends Controller
{
    public function indexAction($order_id)
    {
        $em = $this->getDoctrine()->getManager();
        
        if(is_null($order = $em->getRepository('NGPPGmsagcBundle:Orders')->find($order_id)))
        {
            $this->get('session')->getFlashBag()->add('error',
                    $this->get('translator')->trans('expenses.noorder'));
            return $this->redirect($this->generateUrl('ngpp_gmsagc_home'));
        }
        
        return $this->render('NGPPGmsagcBundle:Expenses:index.html.twig',
                array('expenses' => $this->getDoctrine()->getRepository('NGPPGmsagcBundle:Expenses')->findByOrder($order->getId()),
                      'order' => $order));
    }
    
    public function createAction($order_id)
    {
        $em = $this->getDoctrine()->getManager();
        
        if(is_null($order = $em->getRepository('NGPPGmsagcBundle:Orders')->find($order_id)))
        {
            $this->get('session')->getFlashBag()->add('error',
                    $this->get('translator')->trans('expenses.noorder'));
            return $this->redirect($this->generateUrl('ngpp_gmsagc_expenses', ['order_id' => $order_id]));
        }
        
        $expense = new Expenses($order);
        
        $form = $this->createForm(new ExpensesType(), $expense);

        if ($this->getRequest()->isMethod('POST')) {
            
            if ($form->bind($this->getRequest())->isValid()) {
                            
                $em->persist($expense);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success',
                    $this->get('translator')->trans('expenses.saved'));
                
                return $this->redirect($this->generateUrl('ngpp_gmsagc_expenses', ['order_id' => $order_id]));
            }
        }
        
        return $this->render('NGPPGmsagcBundle:Expenses:save.html.twig',
                array('form' => $form->createView(),
                      'order_id' => $order_id));
    }
    
    public function editAction($id)
    {        
        $em = $this->getDoctrine()->getManager();
        
        if(is_null($expense = $em->getRepository('NGPPGmsagcBundle:Expenses')->find($id)))
            return $this->redirect($this->generateUrl('ngpp_gmsagc_home'));
        
        $form = $this->createForm(new ExpensesType(), $expense);

        if ($this->getRequest()->isMethod('POST')) {
            
            if ($form->bind($this->getRequest())->isValid()) {
                            
                $em->persist($expense);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success',
                    $this->get('translator')->trans('expenses.saved'));
                
                return $this->redirect($this->generateUrl('ngpp_gmsagc_expenses'));
            }
        }
        
        return $this->render('NGPPGmsagcBundle:Expenses:save.html.twig',
                array('form' => $form->createView(),
                      'order_id' => $expense->getOrderId()));
    }
    
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $expense = $em->getRepository('NGPPGmsagcBundle:Expenses')->find($id);
        
        $redirect_url = $this->generateUrl('ngpp_gmsagc_home');

        if(!is_null($expense))
        {
            $redirect_url = $this->generateUrl('ngpp_gmsagc_expenses', ['order_id' => $expense->getOrderId()]);
            
            $em->remove($expense);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success',
                    $this->get('translator')->trans('expenses.deleted'));
        }
        else
            $this->get('session')->getFlashBag()->add('error',
                    $this->get('translator')->trans('expenses.nodeleted'));
        
        return $this->redirect($redirect_url);
    }
}
