<?php

namespace NGPP\GmsagcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use \NGPP\GmsagcBundle\Entity\Hours;
use \NGPP\GmsagcBundle\Form\Type\CalendarType;

class Calendar
{
    public $hours;
    
    public function __construct() {
        $this->hours = new \Doctrine\Common\Collections\ArrayCollection();
    }
}

class HoursController extends Controller
{
    public function indexAction($week = null, $year = null)
    {
        $week = $week ?: date('W');
        $year = $year ?: date('Y');
        
        $start = new \DateTime($year . 'W' . $week);
        $users = $this->getDoctrine()->getRepository('NGPPGmsagcBundle:Users')->findAll();
        
        $order = $this->getDoctrine()->getRepository('NGPPGmsagcBundle:Orders')->findOneById(1);
        
        $calendar = new Calendar();
        
        foreach ($users as $user)
        {
            for ($i = 0; $i < 5; $i++)
            {
                $hour = new Hours();
                $hour->setDay($start);
                $hour->setUser($user);
                $hour->setOrder($order);
                
                $calendar->hours->add($hour);
            }
        }
        
        $form = $this->createForm(new CalendarType(), $calendar);
        
        
        if ($this->getRequest()->isMethod('POST')) {
            
            if ($form->bind($this->getRequest())->isValid()) {

                $em = $this->getDoctrine()->getManager();
                
                foreach($calendar->hours as $hour)
                {
                    $time = $hour->getTime();
                    is_null($time) || $time->getTimestamp() <= 0 ?: $em->persist($hour);
                }
                $em->flush();

                $this->get('session')->getFlashBag()->add('success',
                    $this->get('translator')->trans('hours.saved'));
                
                return $this->redirect($this->generateUrl('ngpp_gmsagc_hours'));
            }
        }
        
        return $this->render('NGPPGmsagcBundle:Hours:index.html.twig',
                array('start' => $start,
                    'users' => $users,
                    'form' => $form->createView()));
    }
 
    
//    public function indexAction()
//    {
//        return $this->render('NGPPGmsagcBundle:Hours:index.html.twig',
//                array('hours' => $this->getDoctrine()->getRepository('NGPPGmsagcBundle:Hours')->findAll()));
//    }
//    
//    public function createAction($order_id)
//    {
//        $em = $this->getDoctrine()->getManager();
//        
//        if(is_null($order = $em->getRepository('NGPPGmsagcBundle:Orders')->find($order_id)))
//            return $this->redirect($this->generateUrl('ngpp_gmsagc_hours'));
//        
//        $hour = new Hours($order);
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
//    
//    public function editAction($id)
//    {        
//        $em = $this->getDoctrine()->getManager();
//        
//        if(is_null($hour = $em->getRepository('NGPPGmsagcBundle:Hours')->find($id)))
//            return $this->redirect($this->generateUrl('ngpp_gmsagc_hours'));
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
//        return $this->render('NGPPGmsagcBundle:Expenses:save.html.twig',
//                array('form' => $form->createView()));
//    }
//    
//    public function deleteAction($id)
//    {
//        $em = $this->getDoctrine()->getManager();
//        $hour = $em->getRepository('NGPPGmsagcBundle:Hours')->find($id);
//
//        if ($hour)
//        {
//            $em->remove($hour);
//            $em->flush();
//            
//            $this->get('session')->getFlashBag()->add('success',
//                    $this->get('translator')->trans('hours.deleted'));
//        }
//        else
//            $this->get('session')->getFlashBag()->add('error',
//                    $this->get('translator')->trans('hours.nodeleted'));
//        
//        return $this->redirect($this->generateUrl('ngpp_gmsagc_hours'));
//    }
}
