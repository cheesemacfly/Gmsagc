<?php

namespace NGPP\GmsagcBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class UsersRepository extends EntityRepository implements UserProviderInterface
{
    /**
     * Returns an array with all the employees
     * 
     * @return array
     */
    public function getEmployees()
    {
        $result = $this->createQueryBuilder('u')
                        ->where('u.rate IS NOT NULL')
                        ->getQuery()->getResult();
        return $result;
    }
    
    /**
     * Returns a Users entity based on the username
     * 
     * @param string $username
     * @return Users
     * @throws UsernameNotFoundException
     */
    public function loadUserByUsername($username)
    {
        $q = $this
            ->createQueryBuilder('u')
            ->select('u, g')
            ->leftJoin('u.groups', 'g')
            ->where('u.username = :username')
            ->setParameter('username', $username)
            ->getQuery();

        try 
        {
            $user = $q->getSingleResult();
        } 
        catch (NoResultException $e) 
        {
            $message = sprintf('Unable to find an active admin NGPPGmsagcBundle:Users object identified by "%s".', $username);
            throw new UsernameNotFoundException($message, 0, $e);
        }

        return $user;
    }

    /**
     * 
     * @param \Symfony\Component\Security\Core\User\UserInterface $user
     * @return Users
     * @throws UnsupportedUserException
     */
    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) 
        {
            throw new UnsupportedUserException
            (
                sprintf('Instances of "%s" are not supported.', $class)
            );
        }

        return $this->find($user->getId());
    }

    /**
     * 
     * @param type $class
     * @return type
     */
    public function supportsClass($class)
    {
        return $this->getEntityName() === $class || is_subclass_of($class, $this->getEntityName());
    }
    
    /**
     * Returns the total number of items depending on the selection
     * 
     * @param type $criteria
     * @return int
     */
    public function getTotal($criteria = null)
    {
        $query = $this->createQueryBuilder('u')->select('COUNT(u.id)');

        $this->setCriteria($query, $criteria); 
        
        try
        {
            $result = $query->getQuery()->getSingleScalarResult();
        }
        catch(\Doctrine\ORM\NoResultException $e)
        {
            $logger = $this->get('logger');
            $logger->err(sprintf('NoResultException in UsersRepository::getTotal with criteria %s', $criteria));
            
            return 0;
        }
        
        return $result;        
    }
    
    /**
     * Returns an array of Users
     * 
     * @param type $criteria
     * @param int $limit
     * @param int $offset
     * @return type
     */
    public function getList($criteria = null, $limit = null, $offset = null)
    {
        $query = $this->createQueryBuilder('u');

        $this->setCriteria($query, $criteria);        
        $query->setMaxResults($limit);
        $query->setFirstResult($offset);
        
        return $query->getQuery()->getResult();
    }
    
    /**
     * Add where conditions for the Users request
     * 
     * @param type $query
     * @param type $criteria
     * @return type
     */
    private function setCriteria($query, $criteria)
    {
        if(!is_null($criteria))
        {
            $query->where('u.username LIKE :criteria')
                ->orWhere('u.email LIKE :criteria')
                ->setParameter('criteria', '%'.$criteria.'%');
            
            if((int)$criteria > 0)
            {
                $query->orWhere('u.id = :criteria')
                    ->setParameter('criteria', $criteria);
            }
        }
    }
}