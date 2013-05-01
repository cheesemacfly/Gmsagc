<?php

namespace NGPP\GmsagcBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Hours
 * 
 * @ORM\Entity
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
     * @ORM\Column(name="start", type="date")
     * @Assert\NotBlank()
     * @Assert\Type(type="\DateTime")
     */
    private $start;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="end", type="date")
     * @Assert\NotBlank()
     * @Assert\Type(type="\DateTime")
     */
    private $end;

    /**
     * @ORM\ManyToOne(targetEntity="Users", inversedBy="hours")
     */
    protected $user;
    
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
     * Set start
     *
     * @param \DateTime $start
     * @return Hours
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime 
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set end
     *
     * @param \DateTime $end
     * @return Hours
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime 
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set user
     *
     * @param \NGPP\GmsagcBundle\Entity\Users $user
     * @return Hours
     */
    public function setUser(\NGPP\GmsagcBundle\Entity\Users $user = null)
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
