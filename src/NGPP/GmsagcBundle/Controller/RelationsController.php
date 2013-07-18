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
            $currentDate = (new \DateTime($firstInvoiced[1]))->modify('first day of this month');
            $now = new \DateTime();
            
            while($currentDate < $now)
            {
                $year = $currentDate->format('Y');
                $month = $currentDate->format('F');

                if(!array_key_exists($year, $dates))
                {
                    $dates[] = $year;
                    $dates[$year] = array();
                }
                
                if(!array_key_exists($month, $dates[$year]))
                    $dates[$year][] = $month;
                
                $currentDate->add(new \DateInterval('P1M'));
            }
            
            return $this->render('NGPPGmsagcBundle:Relations:index.html.twig',
                    array('relations' => $repo->findByType($this->container->getParameter('ngpp_gmsagc.types')['customer']),
                    'firstInvoiced' => $dates));
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
