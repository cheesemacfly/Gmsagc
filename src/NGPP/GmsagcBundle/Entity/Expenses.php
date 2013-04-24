<?php

namespace NGPP\GmsagcBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Expenses
 *
 * @ORM\Entity
 */
class Expenses
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
     * @ORM\Column(name="description", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="decimal", precision=12, scale=2)
     * @Assert\NotBlank()
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="observation", type="text", nullable=true)
     */
    private $observation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="date")
     * @Assert\NotBlank()
     * @Assert\Type(type="\DateTime")
     */
    private $created;
    
    /**
     * @ORM\ManyToOne(targetEntity="Contacts", inversedBy="expenses")
     */
    protected $contact;
    
    /**
     * @ORM\ManyToOne(targetEntity="Orders", inversedBy="expenses")
     */
    protected $order;

    public function __construct($order = null)
    {
        $this->order = $order;
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
     * Set description
     *
     * @param string $description
     * @return Expenses
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return Expenses
     */
    public function setPrice($price)
    {
        $this->price = $price;
    
        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set observation
     *
     * @param string $observation
     * @return Expenses
     */
    public function setObservation($observation)
    {
        $this->observation = $observation;
    
        return $this;
    }

    /**
     * Get observation
     *
     * @return string 
     */
    public function getObservation()
    {
        return $this->observation;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Expenses
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set contact
     *
     * @param \NGPP\GmsagcBundle\Entity\Contacts $contact
     * @return Expenses
     */
    public function setContact(Contacts $contact = null)
    {
        $this->contact = $contact;
    
        return $this;
    }

    /**
     * Get contact
     *
     * @return \NGPP\GmsagcBundle\Entity\Contacts 
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set order
     *
     * @param \NGPP\GmsagcBundle\Entity\Orders $order
     * @return Expenses
     */
    public function setOrder(Orders $order = null)
    {
        $this->order = $order;
    
        return $this;
    }

    /**
     * Get order
     *
     * @return \NGPP\GmsagcBundle\Entity\Orders 
     */
    public function getOrder()
    {
        return $this->order;
    }
}
