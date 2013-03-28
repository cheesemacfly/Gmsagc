<?php

namespace NGPP\GmsagcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \NGPP\GmsagcBundle\Entity\Molds;
use \NGPP\GmsagcBundle\Form\Type\MoldsType;

class MoldsController extends Controller
{
    public function indexAction()
    {
        return $this->render('NGPPGmsagcBundle:Molds:index.html.twig',
                array('molds' => $this->getDoctrine()->getRepository('NGPPGmsagcBundle:Molds')->findAll()));
    }
    
    public function saveAction($id = null)
    {
        $em = $this->getDoctrine()->getManager();
        
        //Determine if editing or creating
        $mold = !is_null($id) && !is_null($mold = $em->getRepository('NGPPGmsagcBundle:Molds')->find($id)) ? 
                $mold : new Molds($em->getRepository('NGPPGmsagcBundle:Molds')->getNewId());
                        
        $form = $this->createForm(new MoldsType(), $mold);

        if ($this->getRequest()->isMethod('POST')) {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $em->persist($mold);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success',
                    $this->get('translator')->trans('molds.saved'));
                
                return $this->redirect($this->generateUrl('ngpp_gmsagc_molds'));
            }
        }
        
        return $this->render('NGPPGmsagcBundle:Molds:save.html.twig',
                array('form' => $form->createView()));
    }
    
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $mold = $em->getRepository('NGPPGmsagcBundle:Molds')->find($id);

        if ($mold)
        {
            $em->remove($mold);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success',
                    $this->get('translator')->trans('molds.deleted'));
        }
        else
            $this->get('session')->getFlashBag()->add('error',
                    $this->get('translator')->trans('molds.nodeleted'));
        
        return $this->redirect($this->generateUrl('ngpp_gmsagc_molds'));
    }
}
