<?php

namespace NGPP\GmsagcBundle\Lib;

use Doctrine\ORM\EntityManager;
use NGPP\GmsagcBundle\Entity\Hours;

/**
 * Calendar class for the hours controller support
 *
 * @author nicolas
 */
class Calendar {

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var Array
     */
    private $hours;

    /**
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->hours = [];
        $this->em = $em;
    }

    /**
     * Load hours from database or create object if it doesn't exist
     *
     * @param Users $user
     * @param Orders $order
     */
    public function populate($users, $order, $start_day)
    {
        foreach ($users as $user)
        {
            for ($i = 0; $i < 5; $i++)
            {
                $dolly = clone $start_day;
                $dolly->add(new \DateInterval('P' . $i . 'D'));

                if (is_null($hour = $this->em->getRepository('NGPPGmsagcBundle:Hours')->getHour($user->getId(), $order->getId(), $dolly)))
                {
                    $hour = new Hours();

                    $hour->setDay($dolly);
                    $hour->setUser($user);
                    $hour->setOrder($order);
                }

                $this->hours[] = $hour;
            }
        }
    }

    /**
     * Get hours
     *
     * @return array
     */
    public function getHours()
    {
        return $this->hours;
    }

    /**
     * Set hours
     * 
     * @param array $hours
     * @return array
     */
    public function setHours(array $hours)
    {
        $this->hours = $hours;

        return $this->hours;
    }
}

?>
