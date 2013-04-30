<?php

namespace NGPP\GmsagcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \NGPP\GmsagcBundle\Entity\Expenses;
use \NGPP\GmsagcBundle\Form\Type\ExpensesType;

class ExpensesController extends Controller
{
    public function indexAction()
    {
        return $this->render('NGPPGmsagcBundle:Expenses:index.html.twig',
                array('expenses' => $this->getDoctrine()->getRepository('NGPPGmsagcBundle:Expenses')->findAll()));
    }
    
    public function createAction($order_id)
    {
        $em = $this->getDoctrine()->getManager();
        
        if(is_null($order = $em->getRepository('NGPPGmsagcBundle:Orders')->find($order_id)))
            return $this->redirect($this->generateUrl('ngpp_gmsagc_expenses'));
        
        $expense = new Expenses($order);
        
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
                array('form' => $form->createView()));
    }
    
    public function editAction($id)
    {        
        $em = $this->getDoctrine()->getManager();
        
        if(is_null($expense = $em->getRepository('NGPPGmsagcBundle:Expenses')->find($id)))
            return $this->redirect($this->generateUrl('ngpp_gmsagc_expenses'));
        
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
                array('form' => $form->createView()));
    }
    
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $expense = $em->getRepository('NGPPGmsagcBundle:Expenses')->find($id);

        if ($expense)
        {   
            $em->remove($expense);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success',
                    $this->get('translator')->trans('expenses.deleted'));
        }
        else
            $this->get('session')->getFlashBag()->add('error',
                    $this->get('translator')->trans('expenses.nodeleted'));
        
        return $this->redirect($this->generateUrl('ngpp_gmsagc_expenses'));
    }
}
