<?php

namespace NGPP\GmsagcBundle\Entity;

use Doctrine\ORM\EntityRepository;

class MoldsRepository extends EntityRepository
{
    /**
     * Return last id+1 or 1 if not found
     * 
     * @return int
     */
    public function getNewId()
    {
        $query = $this->createQueryBuilder('m')->select('MAX(m.id)');
        
        try
        {
            $result = $query->getQuery()->getSingleScalarResult();
        }
        catch(\Doctrine\ORM\NoResultException $e)
        {
            $logger = $this->get('logger');
            $logger->err(sprintf('NoResultException in MoldsRepository::getNewId'));
            
            return 1;
        }
        
        return $result;
    }
    
    /**
     * Returns the total number of items depending on the selection
     * 
     * @param type $criteria
     * @return int
     */
    public function getTotal($criteria = null)
    {
        $query = $this->createQueryBuilder('m')->select('COUNT(m.id)');

        $this->setCriteria($query, $criteria); 
        
        try
        {
            $result = $query->getQuery()->getSingleScalarResult();
        }
        catch(\Doctrine\ORM\NoResultException $e)
        {
            $logger = $this->get('logger');
            $logger->err(sprintf('NoResultException in MoldsRepository::getTotal with criteria %s', $criteria));
            
            return 0;
        }
        
        return $result;
    }
    
    /**
     * Returns an array of Molds
     * 
     * @param type $criteria
     * @param int $limit
     * @param int $offset
     * @return type
     */
    public function getList($criteria = null, $limit = null, $offset = null)
    {
        $query = $this->createQueryBuilder('m');

        $this->setCriteria($query, $criteria);        
        $query->setMaxResults($limit);
        $query->setFirstResult($offset);
        
        return $query->getQuery()->getResult();
    }
    
    /**
     * Add where conditions for the Molds request
     * 
     * @param type $query
     * @param type $criteria
     */
    private function setCriteria($query, $criteria)
    {
        if(!is_null($criteria))
        {
            $query->where('m.name LIKE :criteria')
                ->orWhere('m.place LIKE :criteria')
                ->setParameter('criteria', '%'.$criteria.'%');

            if((int)$criteria > 0)
            {
                $query->orWhere('m.id = :criteria')
                    ->setParameter('criteria', $criteria);
            }
        }
    }
}
