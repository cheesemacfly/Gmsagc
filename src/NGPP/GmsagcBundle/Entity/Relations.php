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
    /** @ORM\Id @ORM\ManyToOne(targetEntity="Contacts") */
    private $contact_id;
    
    /** @ORM\Id @ORM\ManyToOne(targetEntity="Orders") */
    private $order_id;
    
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
     * @param \NGPP\GmsagcBundle\Entity\Contacts $contactId
     * @return Relations
     */
    public function setContactId(\NGPP\GmsagcBundle\Entity\Contacts $contactId)
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
     * Set order_id
     *
     * @param \NGPP\GmsagcBundle\Entity\Orders $orderId
     * @return Relations
     */
    public function setOrderId(\NGPP\GmsagcBundle\Entity\Orders $orderId)
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
