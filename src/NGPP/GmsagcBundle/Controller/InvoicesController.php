<?php

namespace NGPP\GmsagcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InvoicesController extends Controller
{
    public function indexAction()
    {
        return $this->render('NGPPGmsagcBundle:Invoices:index.html.twig',
                array('invoices' => $this->getDoctrine()->getRepository('NGPPGmsagcBundle:Relations')->findAll()));
    }
    
    public function saveAction($order_id = null, $contact_id = null)
    {
        $em = $this->getDoctrine()->getManager();
                
        //Determine if editing or creating
        if((is_null($order_id) || is_null($contact_id)) || 
                is_null($relation = $em->getRepository('NGPPGmsagcBundle:Relations')->findOneBy(array('order_id' => $order_id, 'contact_id' => $contact_id))))
                return $this->redirect($this->generateUrl('ngpp_gmsagc_invoices'));
        
        $form = $this->createForm(new RelationsType(), $relation);

        if ($this->getRequest()->isMethod('POST')) {                            
            $em->persist($relation);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success',
                $this->get('translator')->trans('invoices.saved'));

            return $this->redirect($this->generateUrl('ngpp_gmsagc_invoices'));
        }
        
        return $this->render('NGPPGmsagcBundle:Invoices:save.html.twig',
                array('form' => $form->createView()));
    }
    
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $relation = $em->getRepository('NGPPGmsagcBundle:Relations')->find($id);

        if ($relation)
        {            
            $em->remove($relation);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success',
                    $this->get('translator')->trans('invoices.deleted'));
        }
        else
            $this->get('session')->getFlashBag()->add('error',
                    $this->get('translator')->trans('invoices.nodeleted'));
        
        return $this->redirect($this->generateUrl('ngpp_gmsagc_invoices'));
    }
}
