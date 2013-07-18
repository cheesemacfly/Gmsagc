<?php

namespace NGPP\GmsagcBundle\Entity;

use Doctrine\ORM\EntityRepository;

class RelationsRepository extends EntityRepository
{
    public function getFirstInvoiced()
    {
        $result = $this->createQueryBuilder('r')
                        ->select('MIN(r.invoiced)')
                        ->getQuery()->getOneOrNullResult();
        
        return $result;
    }
}
