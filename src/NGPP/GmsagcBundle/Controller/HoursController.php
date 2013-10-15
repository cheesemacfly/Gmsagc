<?php

namespace NGPP\GmsagcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use NGPP\GmsagcBundle\Entity\Hours;
use NGPP\GmsagcBundle\Form\Type\CalendarType;

/**
 * @Route("/hours")
 */
class HoursController extends Controller
{
    /**
     * @Route("/{order_id}/{week}/{year}", name="ngpp_gmsagc_hours",
     *  requirements={"order_id" = "\d+", "week" = "^0[1-9]|[1-4][0-9]|5[0-3]$", "year" = "^(20|19)[0-9]{2}$"},
     *  defaults={"week" = null, "year" = null})
     * @Template
     */
    public function indexAction($order_id, $week = null, $year = null)
    {
        //Sanitize week and year
        $week = sprintf('%02d', !is_null($week) ? $week : date('W'));
        $year = sprintf('%04d', !is_null($year) ? $year : date('Y'));

        $start_day = new \DateTime($year . 'W' . $week);

        $em = $this->getDoctrine()->getManager();

        if(count($users = $em->getRepository('NGPPGmsagcBundle:Users')->getEmployees()) < 1)
            return $this->redirect($this->generateUrl('ngpp_gmsagc_home'));

        if(is_null($order = $em->getRepository('NGPPGmsagcBundle:Orders')->findOneById($order_id)))
            return $this->redirect($this->generateUrl('ngpp_gmsagc_home'));

        //PHP doesn't have anonymous types...
        $calendar = new \stdClass();
        $calendar->hours = array();

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
        $form->handleRequest($this->getRequest());

        if ($form->isValid()) {

            //persist only usefull hours
            foreach($calendar->hours as $hour)
            {
                $time = $hour->getTime();
                is_null($time) ?: $em->persist($hour);
            }
            $em->flush();

            $this->get('session')->getFlashBag()->add('success',
                $this->get('translator')->trans('hours.saved'));

            return $this->redirect($this->generateUrl('ngpp_gmsagc_hours',
                                                        array('order_id' => $order->getId(),
                                                                'week' => $week,
                                                                'year' => $year)));
        }

        return array('form' => $form->createView(), 'order' => $order, 'users' => $users, 'week' => $week, 'year' => $year);
    }
}
