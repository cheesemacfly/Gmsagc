<?php

namespace NGPP\GmsagcBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Molds
 *
 * @ORM\Entity(repositoryClass="NGPP\GmsagcBundle\Entity\MoldsRepository")
 */
class Molds
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="weight", type="float", nullable=true)
     * @Assert\Type(type="float")
     */
    private $weight;

    /**
     * @var string
     *
     * @ORM\Column(name="place", type="string", length=255, nullable=true)
     */
    private $place;

    /**
     * @var integer
     *
     * @ORM\Column(name="shell", type="integer", nullable=true)
     * @Assert\Type(type="integer")
     */
    private $shell;

    /**
     * @ORM\OneToMany(targetEntity="Orders", mappedBy="mold")
     */
    protected $orders;

    /**
     * Constructor
     */
    public function __construct($id = null)
    {
        $this->id = $id;
        $this->orders = new ArrayCollection();
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return Molds
     */
    public function setId($id)
    {
        $this->id = $id;
    
        return $this;
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
     * @return Molds
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
     * Set weight
     *
     * @param float $weight
     * @return Molds
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    
        return $this;
    }

    /**
     * Get weight
     *
     * @return float 
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set place
     *
     * @param string $place
     * @return Molds
     */
    public function setPlace($place)
    {
        $this->place = $place;
    
        return $this;
    }

    /**
     * Get place
     *
     * @return string 
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set shell
     *
     * @param integer $shell
     * @return Molds
     */
    public function setShell($shell)
    {
        $this->shell = $shell;
    
        return $this;
    }

    /**
     * Get shell
     *
     * @return integer 
     */
    public function getShell()
    {
        return $this->shell;
    }

    /**
     * Add orders
     *
     * @param \NGPP\GmsagcBundle\Entity\Orders $orders
     * @return Molds
     */
    public function addOrders(Orders $orders)
    {
        $this->orders[] = $orders;
    
        return $this;
    }

    /**
     * Remove orders
     *
     * @param \NGPP\GmsagcBundle\Entity\Orders $orders
     */
    public function removeOrders(Orders $orders)
    {
        $this->orders->removeElement($orders);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrders()
    {
        return $this->orders;
    }
}
