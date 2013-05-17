<?php

namespace NGPP\GmsagcBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Hours
 * 
 * @ORM\Entity(repositoryClass="NGPP\GmsagcBundle\Entity\HoursRepository")
 * @UniqueEntity({"user", "order", "day"})
 */
class Hours
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
     * @var \DateTime
     * 
     * @ORM\Column(name="day", type="date")
     * @Assert\NotBlank()
     * @Assert\Type(type="\DateTime")
     */
    private $day;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="time", type="time")
     * @Assert\NotBlank()
     * @Assert\Type(type="\DateTime")
     */
    private $time;
        
    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    protected $user_id;

    /**
     * @ORM\ManyToOne(targetEntity="Users", inversedBy="hours")
     */
    protected $user;
        
    /**
     * @var integer
     *
     * @ORM\Column(name="order_id", type="integer")
     */
    protected $order_id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Orders", inversedBy="hours")
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
     * Set user
     *
     * @param \NGPP\GmsagcBundle\Entity\Users $user
     * @return Hours
     */
    public function setUser(Users $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \NGPP\GmsagcBundle\Entity\Users 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set order
     *
     * @param \NGPP\GmsagcBundle\Entity\Orders $order
     * @return Hours
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

    /**
     * Set day
     *
     * @param \DateTime $day
     * @return Hours
     */
    public function setDay(\DateTime $day = null)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return \DateTime 
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set time
     *
     * @param \DateTime $time
     * @return Hours
     */
    public function setTime(\DateTime $time = null)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return \DateTime 
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set user_id
     *
     * @param integer $userId
     * @return Hours
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;

        return $this;
    }

    /**
     * Get user_id
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set order_id
     *
     * @param integer $orderId
     * @return Hours
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
}
