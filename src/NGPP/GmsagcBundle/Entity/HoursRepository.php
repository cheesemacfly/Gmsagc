<?php

namespace NGPP\GmsagcBundle\Entity;

use Doctrine\ORM\EntityRepository;

class HoursRepository extends EntityRepository
{
    public function getHour($user_id, $order_id, $day)
    {
        $q = $this->createQueryBuilder('h')
                            ->where('h.user_id = :user_id')
                            ->andWhere('h.order_id = :order_id')
                            ->andWhere('h.day = :day')
                            ->setParameters(['user_id' => $user_id, 'order_id' => $order_id, 'day' => $day])
                            ->getQuery();
        try
        {
            $result = $q->getSingleResult();
        }
        catch(\Doctrine\Orm\NoResultException $e)
        {
            return null;
        }
        catch(\Doctrine\ORM\NonUniqueResultException $e)
        {
            $logger = $this->get('logger');
            $logger->err('NonUniqueResultException in HoursRepository::getHour with user_id '.$user_id.' and order_id'.$order_id.' and day: '.$day);
            
            return null;
        }
        
        return $result;
    }
}
