<?php

namespace NGPP\GmsagcBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Relation
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Relations
{
    /**
     * @var integer
     *
     * @ORM\Column(name="contact_id", type="integer")
     * @ORM\Id
     */
    private $contact_id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Contacts", inversedBy="relations")
     */
    protected $contact;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="order_id", type="integer")
     * @ORM\Id
     */
    private $order_id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Orders", inversedBy="relations")
     */
    protected $order;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="invoice", type="integer", nullable=true)
     */
    private $invoice;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="invoiced", type="datetime", nullable=true)
     */
    private $invoiced;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="type_id", type="integer")
     */
    private $type_id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Types", inversedBy="relations")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    protected $type;


    /**
     * Set invoice
     *
     * @param integer $invoice
     * @return Relations
     */
    public function setInvoice($invoice)
    {
        $this->invoice = $invoice;
    
        return $this;
    }

    /**
     * Get invoice
     *
     * @return integer 
     */
    public function getInvoice()
    {
        return $this->invoice;
    }

    /**
     * Set invoiced
     *
     * @param \DateTime $invoiced
     * @return Relations
     */
    public function setInvoiced($invoiced)
    {
        $this->invoiced = $invoiced;
    
        return $this;
    }

    /**
     * Get invoiced
     *
     * @return \DateTime 
     */
    public function getInvoiced()
    {
        return $this->invoiced;
    }

    /**
     * Set type_id
     *
     * @param integer $typeId
     * @return Relations
     */
    public function setTypeId($typeId)
    {
        $this->type_id = $typeId;
    
        return $this;
    }

    /**
     * Get type_id
     *
     * @return integer 
     */
    public function getTypeId()
    {
        return $this->type_id;
    }

    /**
     * Set contact_id
     *
     * @param integer $contactId
     * @return Relations
     */
    public function setContactId($contactId)
    {
        $this->contact_id = $contactId;
    
        return $this;
    }

    /**
     * Get contact_id
     *
     * @return \NGPP\GmsagcBundle\Entity\Contacts 
     */
    public function getContactId()
    {
        return $this->contact_id;
    }

    /**
     * Set contact
     *
     * @param \NGPP\GmsagcBundle\Entity\Contacts $contact
     * @return Relations
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
     * Set order_id
     *
     * @param integer $orderId
     * @return Relations
     */
    public function setOrderId($orderId)
    {
        $this->order_id = $orderId;
    
        return $this;
    }

    /**
     * Get order_id
     *
     * @return \NGPP\GmsagcBundle\Entity\Orders 
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * Set order
     *
     * @param \NGPP\GmsagcBundle\Entity\Orders $order
     * @return Relations
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

    /**
     * Set type
     *
     * @param \NGPP\GmsagcBundle\Entity\Types $type
     * @return Relations
     */
    public function setType(\NGPP\GmsagcBundle\Entity\Types $type = null)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return \NGPP\GmsagcBundle\Entity\Types 
     */
    public function getType()
    {
        return $this->type;
    }
}
