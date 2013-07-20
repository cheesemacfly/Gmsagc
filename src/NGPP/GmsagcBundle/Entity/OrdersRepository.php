<?php

namespace NGPP\GmsagcBundle\Entity;

use Doctrine\ORM\EntityRepository;

class OrdersRepository extends EntityRepository
{
    /**
     * Returns the total number of items depending on the selection
     * 
     * @param type $criteria
     * @return int
     */
    public function getTotal($criteria = null)
    {
        $query = $this->createQueryBuilder('o')->select('COUNT(o.id)');

        $this->setCriteria($query, $criteria); 
        
        try
        {
            $result = $query->getQuery()->getSingleScalarResult();
        }
        catch(\Doctrine\ORM\NoResultException $e)
        {
            $logger = $this->get('logger');
            $logger->err(sprintf('NoResultException in OrdersRepository::getTotal with criteria %s', $criteria));
            
            return 0;
        }
        
        return $result;        
    }
    
    /**
     * Returns an array of Orders
     * 
     * @param type $criteria
     * @param int $limit
     * @param int $offset
     * @return Orders
     */
    public function getList($criteria = null, $limit = null, $offset = null)
    {
        $query = $this->createQueryBuilder('o');

        $this->setCriteria($query, $criteria);        
        $query->setMaxResults($limit);
        $query->setFirstResult($offset);
        
        return $query->getQuery()->getResult();
    }
    
    /**
     * Add where conditions for the Orders request
     * 
     * @param type $query
     * @param type $criteria
     * @return type
     */
    private function setCriteria($query, $criteria)
    {
        if(!is_null($criteria))
        {
            $query->leftJoin('o.mold', 'mo')
                ->leftJoin('o.press', 'p')
                ->leftJoin('o.material', 'ma')
                ->where('o.observation LIKE :criteria')
                ->orWhere('mo.name LIKE :criteria')
                ->orWhere('ma.name LIKE :criteria')
                ->orWhere('p.name LIKE :criteria')
                ->setParameter('criteria', '%'.$criteria.'%');

            if((int)$criteria > 0)
            {
                $query->orWhere('o.id = :criteria')
                    ->setParameter('criteria', $criteria);
            }            
        }
        
        return $query;
    }
}
