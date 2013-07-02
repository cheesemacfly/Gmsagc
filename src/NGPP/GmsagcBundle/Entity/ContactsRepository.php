<?php

namespace NGPP\GmsagcBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ContactsRepository extends EntityRepository
{
    public function getTotal($criteria = null)
    {
        $query = $this->createQueryBuilder('c')->select('count(c.id)');
                
        if(!is_null($criteria))
        {
            $query = $query->where('c.name LIKE :criteria')
                ->orWhere('c.email LIKE :criteria')
                ->orWhere('c.phone LIKE :criteria')
                ->setParameter('criteria', '%'.$criteria.'%');
        }
        
        try
        {
            $result = $query->getQuery()->getSingleScalarResult();
        }
        catch(\Doctrine\ORM\NoResultException $e)
        {
            $logger = $this->get('logger');
            $logger->err(sprintf('NoResultException in ContactsRepository::getTotal with criteria %s', $criteria));
            
            return 0;
        }
        
        return $result;        
    }
    
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
        
        return $query->getQuery()->getResult();
    }
}
