<?php

namespace NGPP\GmsagcBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Expenses
 *
 * @ORM\Table()
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
     * @var integer
     *
     * @ORM\Column(name="refOrder", type="integer")
     */
    private $refOrder;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="observation", type="text", nullable=true)
     */
    private $observation;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="contact_id", type="integer")
     */
    private $contact_id;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="order_id", type="integer")
     */
    private $order_id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Contacts", inversedBy="expenses")
     * @ORM\JoinColumn(name="contact_id", referencedColumnName="id")
     */
    protected $contact;
    
    /**
     * @ORM\ManyToOne(targetEntity="Orders", inversedBy="expenses")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     */
    protected $order;


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
     * Set refOrder
     *
     * @param integer $refOrder
     * @return Expenses
     */
    public function setRefOrder($refOrder)
    {
        $this->refOrder = $refOrder;
    
        return $this;
    }

    /**
     * Get refOrder
     *
     * @return integer 
     */
    public function getRefOrder()
    {
        return $this->refOrder;
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
     * Set type
     *
     * @param string $type
     * @return Expenses
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
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
     * Set contact_id
     *
     * @param integer $contactId
     * @return Expenses
     */
    public function setContactId($contactId)
    {
        $this->contact_id = $contactId;
    
        return $this;
    }

    /**
     * Get contact_id
     *
     * @return integer 
     */
    public function getContactId()
    {
        return $this->contact_id;
    }

    /**
     * Set order_id
     *
     * @param integer $orderId
     * @return Expenses
     */
    public function setOrderId($orderId)
    {
        $this->order_id = $orderId;
    
        return $this;
    }

    /**
     * Get order_id
     *
     * @return integer 
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * Set contact
     *
     * @param \NGPP\GmsagcBundle\Entity\Contacts $contact
     * @return Expenses
     */
    public function setContact(\NGPP\GmsagcBundle\Entity\Contacts $contact = null)
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
    public function setOrder(\NGPP\GmsagcBundle\Entity\Orders $order = null)
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
