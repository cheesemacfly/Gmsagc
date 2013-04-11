<?php

namespace NGPP\GmsagcBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use NGPP\GmsagcBundle\Entity\Types;

class LoadTypesData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $manager->persist(new Types(1, 'OWNER'));
        $manager->persist(new Types(2, 'CUSTOMER'));
        $manager->persist(new Types(3, 'PROVIDER'));
        $manager->flush();
    }
}