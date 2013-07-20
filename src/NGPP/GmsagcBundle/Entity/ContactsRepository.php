<?php

namespace NGPP\GmsagcBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ContactsRepository extends EntityRepository
{
    /**
     * Returns the total number of items depending on the selection
     * 
     * @param type $criteria
     * @return int
     */
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
    
    /**
     * Returns an array of Contacts
     * 
     * @param type $criteria
     * @param int $limit
     * @param int $offset
     * @return type
     */
    public function getList($criteria = null, $limit = null, $offset = null)
    {
        $query = $this->createQueryBuilder('c');

        $this->setCriteria($query, $criteria);        
        $query->setMaxResults($limit);
        $query->setFirstResult($offset);
        
        return $query->getQuery()->getResult();
    }
    
    /**
     * Add where conditions for the Contacts request
     * 
     * @param type $query
     * @param type $criteria
     * @return type
     */
    private function setCriteria($query, $criteria)
    {
        if(!is_null($criteria))
        {
            $query->where('c.name LIKE :criteria')
                ->orWhere('c.email LIKE :criteria')
                ->orWhere('c.phone LIKE :criteria')
                ->setParameter('criteria', '%'.$criteria.'%');
            
            if((int)$criteria > 0)
            {
                $query->orWhere('c.id = :criteria')
                    ->setParameter('criteria', $criteria);
            }
        }
        
        return $query;
    }
}
