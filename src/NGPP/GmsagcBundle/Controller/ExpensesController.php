<?php

namespace NGPP\GmsagcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use NGPP\GmsagcBundle\Entity\Expenses;
use NGPP\GmsagcBundle\Entity\Orders;
use NGPP\GmsagcBundle\Form\Type\ExpensesType;

/**
 * @Route("/expenses")
 */
class ExpensesController extends Controller
{
    /**
     * @Route("/{order_id}", name="ngpp_gmsagc_expenses", requirements={"order_id" = "\d+"})
     * @Template
     */
    public function indexAction($order_id)
    {
        $em = $this->getDoctrine()->getManager();
        
        if(is_null($order = $em->getRepository('NGPPGmsagcBundle:Orders')->find($order_id)))
        {
            $this->get('session')->getFlashBag()->add('error',
                    $this->get('translator')->trans('expenses.noorder'));
            return $this->redirect($this->generateUrl('ngpp_gmsagc_home'));
        }
        
        return array('expenses' => $this->getDoctrine()->getRepository('NGPPGmsagcBundle:Expenses')->findByOrder($order->getId()),
                      'order' => $order);
    }
    
    /**
     * @Route("/create/{order_id}", name="ngpp_gmsagc_expenses_create", requirements={"order_id" = "\d+"})
     * @ParamConverter("order", class="NGPPGmsagcBundle:Orders", options={"id" = "order_id"})
     * @Template("NGPPGmsagcBundle:Expenses:save.html.twig")
     */
    public function createAction(Orders $order)
    {
        $em = $this->getDoctrine()->getManager();
        
        $expense = new Expenses($order);
        $form = $this->createForm(new ExpensesType(), $expense);
        $form->handleRequest($this->getRequest());
        
        if ($form->isValid()) {

            $em->persist($expense);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success',
                $this->get('translator')->trans('expenses.saved'));

            return $this->redirect($this->generateUrl('ngpp_gmsagc_expenses', ['order_id' => $order->getId()]));
        }
        
        return array('form' => $form->createView(), 'order_id' => $order->getId());
    }
    
    /**
     * @Route("/edit/{id}", name="ngpp_gmsagc_expenses_edit", requirements={"id" = "\d+"})
     * @Template("NGPPGmsagcBundle:Expenses:save.html.twig")
     */
    public function editAction(Expenses $expense)
    {        
        $em = $this->getDoctrine()->getManager();
        
        $form = $this->createForm(new ExpensesType(), $expense);
        $form->handleRequest($this->getRequest());
            
        if ($form->isValid()) {

            $em->persist($expense);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success',
                $this->get('translator')->trans('expenses.saved'));

            return $this->redirect($this->generateUrl('ngpp_gmsagc_expenses'));
        }
        
        return array('form' => $form->createView(), 'order_id' => $expense->getOrderId());
    }
    
    /**
     * @Route("/delete/{id}", name="ngpp_gmsagc_expenses_delete", requirements={"id" = "\d+"})
     */
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
