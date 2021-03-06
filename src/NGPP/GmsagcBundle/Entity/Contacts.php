<?php

namespace NGPP\GmsagcBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Contacts
 *
 * @ORM\Entity(repositoryClass="NGPP\GmsagcBundle\Entity\ContactsRepository")
 */
class Contacts
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     * @Assert\Email()
     */
    private $email;
    
    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=50, nullable=true)
     */
    private $phone;

    /**
     * @ORM\OneToMany(targetEntity="Addresses", mappedBy="contact", cascade={"persist"})
     */
    protected $addresses;

    /**
     * @ORM\OneToMany(targetEntity="Expenses", mappedBy="contact")
     */
    protected $expenses;
    
    /**
     * @ORM\OneToMany(targetEntity="Relations", mappedBy="contact")
     */
    protected $relations;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->addresses = new ArrayCollection();
        $this->expenses = new ArrayCollection();
        $this->relations = new ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Contacts
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Contacts
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Contacts
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    
        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Add address
     *
     * @param \NGPP\GmsagcBundle\Entity\Addresses $address
     * @return Contacts
     */
    public function addAddresses(Addresses $address)
    {
        $this->addresses[] = $address;
    
        return $this;
    }

    /**
     * Remove address
     *
     * @param \NGPP\GmsagcBundle\Entity\Addresses $address
     */
    public function removeAddresses(Addresses $address)
    {
        $this->addresses->removeElement($address);
    }
    
    /**
     * Set addresses
     * 
     * @param \Doctrine\Common\Collections\ArrayCollection $addresses
     */
    public function setAddresses($addresses)
    {
        foreach ($addresses as $address) {
            $address->setContact($this);
        }

        $this->addresses = $addresses;
    }

    /**
     * Get addresses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * Add expenses
     *
     * @param \NGPP\GmsagcBundle\Entity\Expenses $expenses
     * @return Contacts
     */
    public function addExpenses(Expenses $expenses)
    {
        $this->expenses[] = $expenses;
    
        return $this;
    }

    /**
     * Remove expenses
     *
     * @param \NGPP\GmsagcBundle\Entity\Expenses $expenses
     */
    public function removeExpenses(Expenses $expenses)
    {
        $this->expenses->removeElement($expenses);
    }

    /**
     * Get expenses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getExpenses()
    {
        return $this->expenses;
    }

    /**
     * Add relations
     *
     * @param \NGPP\GmsagcBundle\Entity\Relations $relations
     * @return Contacts
     */
    public function addRelations(Relations $relations)
    {
        $this->relations[] = $relations;

        return $this;
    }

    /**
     * Remove relations
     *
     * @param \NGPP\GmsagcBundle\Entity\Relations $relations
     */
    public function removeRelations(Relations $relations)
    {
        $this->relations->removeElement($relations);
    }
    
    /**
     * Set relations
     * 
     * @param \Doctrine\Common\Collections\ArrayCollection $relations
     */
    public function setRelations($relations)
    {
        foreach ($relations as $relation) {
            $relation->setContact($this);
        }

        $this->$relations = $relations;
    }

    /**
     * Get relations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRelations()
    {
        return $this->relations;
    }
}
