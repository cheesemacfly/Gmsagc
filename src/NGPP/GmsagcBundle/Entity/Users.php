<?php

namespace NGPP\GmsagcBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Users
 *
 * @ORM\Entity(repositoryClass="NGPP\GmsagcBundle\Entity\UsersRepository")
 */
class Users implements AdvancedUserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $salt;

    /**
     * @ORM\Column(type="string", length=40)
     * @Assert\NotBlank()
     * @Assert\Length(min=6)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="decimal", precision=6, scale=2, nullable=true)
     */
    private $rate;
    
    /**
     * @ORM\Column(name="is_active", type="boolean")
     * @Assert\Type(type="boolean")
     */
    private $isActive;
    
    /**
     * @ORM\ManyToMany(targetEntity="Groups", inversedBy="users")
     * @ORM\JoinTable(name="Users_Groups")
     *
     */
    private $groups;
    
    /**
     * @ORM\OneToMany(targetEntity="Hours", mappedBy="user")
     */
    protected $hours;

    public function __construct()
    {        
        $this->isActive = true;
        $this->salt = md5(uniqid(null, true));
        $this->groups = new ArrayCollection();
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
    public function getUsername()
    {
        return $this->username;
    }
    
    /**
     * @inheritDoc
     */
    public function setUsername($username)
    {
        $this->username = $username;
        
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    /**
     * @inheritDoc
     */
    public function setPassword($password)
    {
        $this->password = $password;
        
        return $this;
    }
    
    /**
     * @inheritDoc
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * @inheritDoc
     */
    public function setEmail($email = null)
    {
        $this->email = $email;
        
        return $this;
    }
    
    /**
     * @inheritDoc
     */
    public function getRate()
    {
        return $this->rate;
    }
    
    /**
     * @inheritDoc
     */
    public function setRate($rate = null)
    {
        $this->rate = $rate;
        
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
        
        return $this;
    }
    
    /**
     * @inheritDoc
     */
    public function getGroups()
    {
        return $this->groups;
    }
    
    /**
     * @inheritDoc
     */
    public function setGroups($groups)
    {
        $this->groups = $groups;
        
        return $this;
    }
    
    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return $this->groups->toArray();
    }
    
    /**
     * @inheritDoc
     */
    public function setRoles($groups)
    {
        $this->groups = $groups;
        
        return $this;
    }
    
    /**
     * @inheritDoc
     */
    public function addRole(\NGPP\GmsagcBundle\Entity\Groups $group)
    {
        $this->groups[] = $group;
    
        return $this;
    }
    
    /**
     * @inheritDoc
     */
    public function removeRole(\NGPP\GmsagcBundle\Entity\Groups $group)
    {
        $this->groups->removeElement($group);
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
        ) = unserialize($serialized);
    }
    
    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }
}