<?php

namespace NGPP\GmsagcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use \NGPP\GmsagcBundle\Entity\Hours;
use \NGPP\GmsagcBundle\Form\Type\CalendarType;

class HoursController extends Controller
{
    public function indexAction($order_id, $week = null, $year = null)
    {
        //Sanitize week and year
        $week = preg_match('/0[1-9]|[1-4][0-9]|5[0-3]/', $week) ? $week : date('W');
        $year = preg_match('/[0-9]{4}/', $year) ? $year : date('Y');

        $start_day = new \DateTime($year . 'W' . $week);
        
        $em = $this->getDoctrine()->getManager();
        
        if(count($users = $em->getRepository('NGPPGmsagcBundle:Users')->getEmployees()) < 1)
            return $this->redirect($this->generateUrl('ngpp_gmsagc_home'));
        
        if(is_null($order = $em->getRepository('NGPPGmsagcBundle:Orders')->findOneById($order_id)))
            return $this->redirect($this->generateUrl('ngpp_gmsagc_home'));
        
        $calendar = new Calendar();
        
        //Load hours from database or create object if it doesn't exist
        foreach ($users as $user)
        {            
            for ($i = 0; $i < 5; $i++)
            {
                $dolly = clone $start_day;
                $dolly->add(new \DateInterval('P' . $i . 'D'));

                if (is_null($hour = $em->getRepository('NGPPGmsagcBundle:Hours')->getHour($user->getId(), $order->getId(), $dolly)))
                {
                    $hour = new Hours();
                
                    $hour->setDay($dolly);
                    $hour->setUser($user);
                    $hour->setOrder($order);
                }
                
                $calendar->hours[] = $hour;
            }
        }
        
        $form = $this->createForm(new CalendarType(), $calendar);
        
        if ($this->getRequest()->isMethod('POST')) {
            
            if ($form->bind($this->getRequest())->isValid()) {
                
                //persist only usefull hours
                foreach($calendar->hours as $hour)
                {
                    $time = $hour->getTime();
                    is_null($time) ?: $em->persist($hour);
                }
                $em->flush();

                $this->get('session')->getFlashBag()->add('success',
                    $this->get('translator')->trans('hours.saved'));
                
                return $this->redirect($this->generateUrl('ngpp_gmsagc_hours', array(
                                                                                'order_id' => $order->getId(),
                                                                                'week' => $week,
                                                                                'year' => $year)));
            }
        }
        
        return $this->render('NGPPGmsagcBundle:Hours:index.html.twig', array(
                                'form' => $form->createView(),
                                'order' => $order,
                                'users' => $users,
                                'week' => $week,
                                'year' => $year));
    }
}
    
/**
* The only goal of this class is to be able to provide an object to the form type
*/
class Calendar
{
    public $hours;

    public function __construct()
    {
        $this->hours = array();
    }
}
