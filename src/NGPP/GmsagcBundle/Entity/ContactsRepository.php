<?php

namespace NGPP\GmsagcBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ContactsRepository extends EntityRepository
{
    public function getTotal($criteria = null)
    {
        $query = $this->createQueryBuilder('c')->select('COUNT(c.id)');

        $this->setCriteria($query, $criteria); 
        
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

        $this->setCriteria($query, $criteria);        
        $query->setMaxResults($limit);
        $query->setFirstResult($offset);
        
        return $query->getQuery()->getResult();
    }
    
    private function setCriteria($query, $criteria)
    {
        if(!is_null($criteria))
        {
            $query->where('c.name LIKE :criteria')
                ->orWhere('c.email LIKE :criteria')
                ->orWhere('c.phone LIKE :criteria')
                ->setParameter('criteria', '%'.$criteria.'%');
        }
    }
}
