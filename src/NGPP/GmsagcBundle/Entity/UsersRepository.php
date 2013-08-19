<?php

namespace NGPP\GmsagcBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Tools\Pagination\Paginator;

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
     * Returns a paginator object built with the input parameters
     * 
     * @param string $criteria
     * @param int $limit
     * @param int $offset
     * @return \Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function getPaginator($criteria = null, $limit = null, $offset = null)
    {        
        $query = $this->createQueryBuilder('u');
        
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
        
        $query->setFirstResult($offset)->setMaxResults($limit);
        
        return new Paginator($query);
    }
}