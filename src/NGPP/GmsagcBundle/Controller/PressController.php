<?php

namespace NGPP\GmsagcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \NGPP\GmsagcBundle\Entity\Press;
use \NGPP\GmsagcBundle\Form\Type\PressType;

class PressController extends Controller
{
    public function indexAction()
    {
        return $this->render('NGPPGmsagcBundle:Press:index.html.twig',
                array('press' => $this->getDoctrine()->getRepository('NGPPGmsagcBundle:Press')->findAll()));
    }
    
    public function saveAction($id = null)
    {
        $em = $this->getDoctrine()->getManager();
        $press = new Press();
        
        //Edit mode
        if(!is_null($id))
            $press = $em->getRepository('NGPPGmsagcBundle:Press')->find($id);
        
        $form = $this->createForm(new PressType(), $press);

        if ($this->getRequest()->isMethod('POST')) {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $em->persist($press);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'The press has been save!');
                
                return $this->redirect($this->generateUrl('ngpp_gmsagc_press'));
            }
        }
        
        return $this->render('NGPPGmsagcBundle:Press:save.html.twig',
                array('form' => $form->createView()));
    }
    
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $press = $em->getRepository('NGPPGmsagcBundle:Press')->find($id);

        if ($press)
        {
            $em->remove($press);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'The press has been deleted!');
        }
        else
            $this->get('session')->getFlashBag()->add('error', 'The press has not been deleted!');
        
        return $this->redirect($this->generateUrl('ngpp_gmsagc_press'));
    }
}
