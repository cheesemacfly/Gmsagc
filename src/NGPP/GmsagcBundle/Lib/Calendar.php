<?php

namespace NGPP\GmsagcBundle\Lib;

use NGPP\GmsagcBundle\Entity\HoursRepository;
use NGPP\GmsagcBundle\Entity\Hours;
use NGPP\GmsagcBundle\Entity\Orders;

/**
 * Calendar class for the hours controller support
 *
 * @author nicolas
 */
class Calendar {

    /**
     * @var HoursRepository
     */
    private $repo;

    /**
     * @var Array
     */
    private $hours;

    /**
     *
     * @param HoursRepository $repo
     */
    public function __construct(HoursRepository $repo)
    {
        $this->hours = [];
        $this->repo = $repo;
    }

    /**
     * Load hours from database or create object if it doesn't exist
     *
     * @param Users $user
     * @param Orders $order
     * @param Datetime $start_day
     */
    public function populate(array $users, Orders $order, \DateTime $start_day)
    {
        foreach ($users as $user)
        {
            for ($i = 0; $i < 5; $i++)
            {
                $dolly = clone $start_day;
                $dolly->add(new \DateInterval('P' . $i . 'D'));

                if (is_null($hour = $this->repo->getHour($user->getId(), $order->getId(), $dolly)))
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
