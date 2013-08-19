<?php

namespace NGPP\GmsagcBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class OrdersRepository extends EntityRepository
{
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
        $query = $this->createQueryBuilder('o');
        
        if(!is_null($criteria))
        {
            $query->leftJoin('o.mold', 'mo')
                ->leftJoin('o.press', 'p')
                ->leftJoin('o.material', 'ma')
                ->leftJoin('o.action', 'a')
                ->where('o.observation LIKE :criteria')
                ->orWhere('mo.name LIKE :criteria')
                ->orWhere('ma.name LIKE :criteria')
                ->orWhere('p.name LIKE :criteria')
                ->orWhere('a.name LIKE :criteria')
                ->setParameter('criteria', '%'.$criteria.'%');

            if((int)$criteria > 0)
            {
                $query->orWhere('o.id = :criteria')
                    ->setParameter('criteria', $criteria);
            }            
        }
        
        $query->setFirstResult($offset)->setMaxResults($limit);
        
        return new Paginator($query);
    }
}
