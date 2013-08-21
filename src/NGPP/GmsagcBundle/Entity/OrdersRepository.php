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
    
    /**
     * Returns a list of order with trials date during the specified week (or current if no parameters are sent)
     * 
     * @param int $week
     * @param int $year
     * @return type
     */
    public function getWeekTrialList($week = null, $year = null)
    {
        $week = sprintf('%02d', !is_null($week) ? $week : date('W'));
        $year = sprintf('%04d', !is_null($year) ? $year : date('Y'));
        
        $monday = new \DateTime($year . 'W' . $week);
        $friday = clone $monday;
        $friday->add(new \DateInterval('P7D'));
        
        $query = $this->createQueryBuilder('o')
                    ->where('o.trial BETWEEN :monday AND :friday')
                    ->setParameter('monday', $monday)
                    ->setParameter('friday', $friday)
                    ->orderBy('o.trial', 'DESC');
        
        return $query->getQuery()->getResult();
    }
}
