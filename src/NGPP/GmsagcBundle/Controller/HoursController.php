<?php

namespace NGPP\GmsagcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \NGPP\GmsagcBundle\Entity\Hours;
use \NGPP\GmsagcBundle\Form\Type\HoursType;

class HoursController extends Controller
{
    public function indexAction()
    {
        return $this->render('NGPPGmsagcBundle:Hours:index.html.twig',
                array('hours' => $this->getDoctrine()->getRepository('NGPPGmsagcBundle:Hours')->findAll()));
    }
    
    public function saveAction($id = null)
    {
        $em = $this->getDoctrine()->getManager();
        $test = $this->getRequest();

        //Determine if editing or creating
        $hour = !is_null($id) && !is_null($hour = $em->getRepository('NGPPGmsagcBundle:Hours')->find($id)) ? 
                $hour : new Hours();
                        
        $form = $this->createForm(new HoursType(), $hour);

        if ($this->getRequest()->isMethod('POST')) {
            
            if ($form->bind($this->getRequest())->isValid()) {
                
                $em->persist($hour);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success',
                    $this->get('translator')->trans('hours.saved'));
                
                return $this->redirect($this->generateUrl('ngpp_gmsagc_hours'));
            }
        }
        
        return $this->render('NGPPGmsagcBundle:Hours:save.html.twig',
                array('form' => $form->createView()));
    }
    
//    public function saveAction($id = null)
//    {
//        $em = $this->getDoctrine()->getManager();
//        
//        //Determine if editing or creating
//        $hour = !is_null($id) && !is_null($hour = $em->getRepository('NGPPGmsagcBundle:Hours')->find($id)) ? 
//                $hour : new Hours($em->getRepository('NGPPGmsagcBundle:Hours')->getNewId());
//                        
//        $form = $this->createForm(new HoursType(), $hour);
//
//        if ($this->getRequest()->isMethod('POST')) {
//            
//            if ($form->bind($this->getRequest())->isValid()) {
//                
//                $em->persist($hour);
//                $em->flush();
//
//                $this->get('session')->getFlashBag()->add('success',
//                    $this->get('translator')->trans('hours.saved'));
//                
//                return $this->redirect($this->generateUrl('ngpp_gmsagc_hours'));
//            }
//        }
//        
//        return $this->render('NGPPGmsagcBundle:Hours:save.html.twig',
//                array('form' => $form->createView()));
//    }
    
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $hour = $em->getRepository('NGPPGmsagcBundle:Hours')->find($id);

        if ($hour)
        {
            $em->remove($hour);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success',
                    $this->get('translator')->trans('hours.deleted'));
        }
        else
            $this->get('session')->getFlashBag()->add('error',
                    $this->get('translator')->trans('hours.nodeleted'));
        
        return $this->redirect($this->generateUrl('ngpp_gmsagc_hours'));
    }
}
