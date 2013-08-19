<?php

namespace NGPP\GmsagcBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class ContactsRepository extends EntityRepository
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
        $query = $this->createQueryBuilder('c');
        
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
        
        $query->setFirstResult($offset)->setMaxResults($limit);
        
        return new Paginator($query);
    }
}
