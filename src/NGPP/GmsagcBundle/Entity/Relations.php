<?php

namespace NGPP\GmsagcBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Relation
 *
 * @ORM\Entity
 * @UniqueEntity({"contact", "order"})
 */
class Relations
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
     * @ORM\ManyToOne(targetEntity="Contacts", inversedBy="relations")
     */
    protected $contact;
        
    /**
     * @ORM\ManyToOne(targetEntity="Orders", inversedBy="relations")
     */
    protected $order;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="invoice", type="integer", nullable=true)
     * @Assert\Type(type="integer")
     */
    private $invoice;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="invoiced", type="date", nullable=true)
     * @Assert\Type(type="\DateTime")
     */
    private $invoiced;
    
    /**
     * @ORM\ManyToOne(targetEntity="Types")
     */
    protected $type;
    
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
