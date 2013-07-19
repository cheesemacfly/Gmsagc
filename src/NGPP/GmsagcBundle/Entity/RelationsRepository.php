<?php

namespace NGPP\GmsagcBundle\Entity;

use Doctrine\ORM\EntityRepository;

class RelationsRepository extends EntityRepository
{
    /**
     * Return first invoice date or null if not found
     * 
     * @return \DateTime
     */
    public function getFirstInvoiced()
    {
        $result = $this->createQueryBuilder('r')
                        ->select('MIN(r.invoiced)')
                        ->getQuery()->getOneOrNullResult();
        if(!is_null($result) && is_array($result))
        {
            $result = new \DateTime($result[1]);
        }
        
        return $result;
    }
    
    public function getList($type, $startDate = null, $endDate = null)
    {
        $query = $this->createQueryBuilder('r')
                ->where('r.type = :type')
                ->setParameter('type', $type);

        if(!is_null($startDate) && !is_null($endDate))
        {
            $query->andWhere('r.invoiced BETWEEN :startDate AND :endDate')
                    ->setParameter('startDate', $startDate)
                    ->setParameter('endDate', $endDate);
        }
        
        $query->orderBy('r.invoiced', 'DESC');
        
        return $query->getQuery()->getResult();
    }
}
