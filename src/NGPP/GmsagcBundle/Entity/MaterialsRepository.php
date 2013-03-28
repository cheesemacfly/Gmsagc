<?php

namespace NGPP\GmsagcBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * MaterialsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MaterialsRepository extends EntityRepository
{
    /**
     * Gets a list of Materials with name field matching the one passed as parameter
     * 
     * @param string $name
     * @param int $limit
     * @return Array
     */
    public function getList($name = null, $limit = 10)
    {
        $result = $this->createQueryBuilder('m')
                        ->where('m.name LIKE :name')
                        ->setParameter('name', '%' . $name . '%')
                        ->setMaxResults($limit)
                        ->getQuery()->getArrayResult();
        
        return $result;
    }
}