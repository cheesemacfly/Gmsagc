<?php

namespace NGPP\GmsagcBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contacts
 *
 * @ORM\Table()
 * @ORM\Entity
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
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="Addresses", mappedBy="contact", cascade={"persist"})
     */
    protected $addresses;

    /**
     * @ORM\OneToMany(targetEntity="Expenses", mappedBy="contacts")
     */
    protected $expenses;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->addresses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->expenses = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add address
     *
     * @param \NGPP\GmsagcBundle\Entity\Addresses $address
     * @return Contacts
     */
    public function addAddresses(\NGPP\GmsagcBundle\Entity\Addresses $address)
    {
        $this->addresses[] = $address;
    
        return $this;
    }

    /**
     * Remove address
     *
     * @param \NGPP\GmsagcBundle\Entity\Addresses $address
     */
    public function removeAddresses(\NGPP\GmsagcBundle\Entity\Addresses $address)
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
    public function addExpense(\NGPP\GmsagcBundle\Entity\Expenses $expenses)
    {
        $this->expenses[] = $expenses;
    
        return $this;
    }

    /**
     * Remove expenses
     *
     * @param \NGPP\GmsagcBundle\Entity\Expenses $expenses
     */
    public function removeExpense(\NGPP\GmsagcBundle\Entity\Expenses $expenses)
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
}