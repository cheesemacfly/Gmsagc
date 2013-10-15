<?php

namespace NGPP\GmsagcBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

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
            $result = $query->getQuery()->getSingleScalarResult() + 1;
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
     * Returns a paginator object built with the input parameters
     * 
     * @param string $criteria
     * @param int $limit
     * @param int $offset
     * @return \Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function getPaginator($criteria = null, $limit = null, $offset = null)
    {        
        $query = $this->createQueryBuilder('m');
        
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
        
        $query->setFirstResult($offset)->setMaxResults($limit);
        
        return new Paginator($query);
    }
}
