<?php

namespace NGPP\GmsagcBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ContactsRepository extends EntityRepository
{
    public function getList($criteria = null, $limit = null, $offset = null)
    {
        $query = $this->createQueryBuilder('c');
                
        if(!is_null($criteria))
        {
            $query = $query->where('c.name LIKE :criteria')
            ->orWhere('c.email LIKE :criteria')
            ->orWhere('c.phone LIKE :criteria')
            ->setParameter('criteria', '%'.$criteria.'%');
        }
        if(!is_null($limit))
        {
            $query = $query->setMaxResults($limit);
        }
        if(!is_null($offset))
        {
            $query = $query->setFirstResult($offset);
        }
        
        try
        {
            $result = $query->getQuery()->execute();
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
