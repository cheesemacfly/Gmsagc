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
    
    /**
     * Get the list of invoices (invoiced and invoice not null) between 2 dates
     * 
     * @param int $type
     * @param date $startDate
     * @param date $endDate
     * @return type
     */
    public function getInvoices($type, $startDate = null, $endDate = null)
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
        else
        {            
            $query->andWhere('r.invoiced IS NULL')
                    ->orWhere('r.invoice IS NULL');
        }
        
        $query->orderBy('r.invoiced', 'DESC');
        
        return $query->getQuery()->getResult();
    }
    
    /**
     * Get the list of relations to build up the reports
     * 
     * @param int $type
     * @param int $mold_id
     * @return type
     */
    public function getReports($type, $mold_id)
    {
        $query = $this->createQueryBuilder('r')
                ->join('r.order', 'o')
                ->where('r.type = :type')
                ->setParameter('type', $type)
                ->andWhere('o.mold = :mold_id')
                ->setParameter('mold_id', $mold_id)
                ->andWhere('r.invoiced IS NOT NULL')
                ->andWhere('r.invoice IS NOT NULL')
                ->orderBy('r.invoiced', 'DESC');
        
        return $query->getQuery()->getResult();
    }
}
