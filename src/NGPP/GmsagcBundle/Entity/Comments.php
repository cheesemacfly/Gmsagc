<?php

namespace NGPP\GmsagcBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comments
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Comments
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
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="order_id", type="integer")
     */
    private $order_id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Orders", inversedBy="comments")
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
     * Set content
     *
     * @param string $content
     * @return Comments
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Comments
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
     * Set order_id
     *
     * @param integer $orderId
     * @return Comments
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
     * Set order
     *
     * @param \NGPP\GmsagcBundle\Entity\Orders $order
     * @return Comments
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
