<?php

namespace NGPP\GmsagcBundle\Entity;

use Symfony\Component\Security\Core\Role\RoleInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Groups
 * 
 * @ORM\Entity()
 */
class Groups implements RoleInterface
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=30)
     */
    private $name;

    /**
     * @ORM\Column(name="role", type="string", length=20, unique=true)
     */
    private $role;

    /**
     * @ORM\ManyToMany(targetEntity="Users", mappedBy="groups")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }
    
    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * @inheritDoc
     */
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }
    
    /**
     * @inheritDoc
     */
    public function getRole()
    {
        return $this->role;
    }
    
    /**
     * @inheritDoc
     */
    public function setRole($role)
    {
        $this->role = $role;
        
        return $this;
    }
    
    
    /**
     * @inheritDoc
     */
    public function getUsers()
    {
        return $this->users->toArray();
    }
    
    /**
     * @inheritDoc
     */
    public function setUsers($users)
    {
        foreach($users as $user)
        {
            $user->addRole($this);
        }
        $this->users = $users;
        
        return $this;
    }
    
    /**
     * @inheritDoc
     */
    public function addUser(Users $user)
    {
        $user->addRole($this);
        $this->users[] = $user;
    
        return $this;
    }
    
    /**
     * @inheritDoc
     */
    public function removeUser(Users $user)
    {
        $this->users->removeElement($user);
    }
}