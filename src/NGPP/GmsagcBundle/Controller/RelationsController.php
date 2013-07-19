<?php

namespace NGPP\GmsagcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use NGPP\GmsagcBundle\Form\Type\InvoicesType;

class RelationsController extends Controller
{
    public function indexAction()
    {
        $repo = $this->getDoctrine()->getRepository('NGPPGmsagcBundle:Relations');
        
        if(!is_null($firstInvoiced = $repo->getFirstInvoiced()))
        {
            $dates = array();
            $firstInvoiced->modify('first day of this month');
            $cursorDate = new \DateTime('first day of this month');
            
            //Magic trick to get the invoices dates (years starting on July)
            while($cursorDate >= $firstInvoiced)
            {
                $iMonth = $cursorDate->format('n');
                $iYear = $iMonth > 5 ? $cursorDate->format('Y') : $cursorDate->format('Y') - 1;
                $iRealYear = $cursorDate->format('Y');

                $sYear = $iYear . ' - ' . ($iYear + 1);
                $sMonth = $cursorDate->format('F');

                if(!array_key_exists($iYear, $dates))
                {
                    $dates[$iYear] = ['name' => $sYear, 'months' => array()];
                }
                
                if(!array_key_exists($iMonth, $dates[$iYear]['months']))
                {
                    $dates[$iYear]['months'][$iMonth] = ['name' => $sMonth, 'year' => $iRealYear];
                }
                
                //Move to previous month
                $cursorDate->sub(new \DateInterval('P1M'));
            }
            
            return $this->render('NGPPGmsagcBundle:Relations:index.html.twig',
                    array('relations' => $repo->findByType($this->container->getParameter('ngpp_gmsagc.types')['customer']),
                    'dates' => $dates));
        }
        else
        {
            return $this->render('NGPPGmsagcBundle:Relations:index.html.twig');
        }
    }
    
    public function saveAction($id = null)
    {
        $em = $this->getDoctrine()->getManager();

        $relation = !is_null($id) ? $em->getRepository('NGPPGmsagcBundle:Relations')->find($id) : null;
        
        if(is_null($relation))
            return $this->redirect($this->generateUrl('ngpp_gmsagc_relations'));
        
        $form = $this->createForm(new InvoicesType(), $relation);

        if ($this->getRequest()->isMethod('POST')) {
            
            if ($form->bind($this->getRequest())->isValid()) {
                
                $em->persist($relation);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success',
                    $this->get('translator')->trans('invoices.saved'));

                return $this->redirect($this->generateUrl('ngpp_gmsagc_relations'));
            }
        }
        
        return $this->render('NGPPGmsagcBundle:Relations:save.html.twig',
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
        
        return $this->redirect($this->generateUrl('ngpp_gmsagc_relations'));
    }
}
