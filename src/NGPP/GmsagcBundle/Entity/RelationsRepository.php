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
}
