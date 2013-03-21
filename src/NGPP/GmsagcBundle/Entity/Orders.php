<?php

namespace NGPP\GmsagcBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Orders
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Orders
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
     * @var \Date
     *
     * @ORM\Column(name="oral", type="date", nullable=true)
     */
    private $oral;

    /**
     * @var \Date
     *
     * @ORM\Column(name="written", type="date", nullable=true)
     */
    private $written;

    /**
     * @var string
     *
     * @ORM\Column(name="observation", type="text", nullable=true)
     */
    private $observation;

    /**
     * @var \Date
     *
     * @ORM\Column(name="trial", type="date", nullable=true)
     */
    private $trial;

    /**
     * @var float
     *
     * @ORM\Column(name="quote", type="float")
     */
    private $quote;

    /**
     * @var integer
     *
     * @ORM\Column(name="pieces", type="integer", nullable=true)
     */
    private $pieces;

    /**
     * @var string
     *
     * @ORM\Column(name="shrinkage", type="string", length=255, nullable=true)
     */
    private $shrinkage;

    /**
     * @var integer
     *
     * @ORM\Column(name="press_id", type="integer")
     */
    private $press_id;

    /**
     * @var integer
     *
     * @ORM\Column(name="material_id", type="integer")
     */
    private $material_id;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="action_id", type="integer")
     */
    private $action_id;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="mold_id", type="integer")
     */
    private $mold_id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Press", inversedBy="orders")
     */
    protected $press;
    
    /**
     * @ORM\ManyToOne(targetEntity="Materials", inversedBy="orders")
     */
    protected $material;
    
    /**
     * @ORM\ManyToOne(targetEntity="Actions", inversedBy="orders")
     */
    protected $action;
    
    /**
     * @ORM\ManyToOne(targetEntity="Molds", inversedBy="orders")
     */
    protected $mold;
    
    /**
     * @ORM\OneToMany(targetEntity="Comments", mappedBy="order")
     */
    protected $comments;

    /**
     * @ORM\OneToMany(targetEntity="Expenses", mappedBy="order")
     */
    protected $expenses;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set oral
     *
     * @param \DateTime $oral
     * @return Orders
     */
    public function setOral($oral)
    {
        $this->oral = $oral;
    
        return $this;
    }

    /**
     * Get oral
     *
     * @return \DateTime 
     */
    public function getOral()
    {
        return $this->oral;
    }

    /**
     * Set written
     *
     * @param \DateTime $written
     * @return Orders
     */
    public function setWritten($written)
    {
        $this->written = $written;
    
        return $this;
    }

    /**
     * Get written
     *
     * @return \DateTime 
     */
    public function getWritten()
    {
        return $this->written;
    }

    /**
     * Set observation
     *
     * @param string $observation
     * @return Orders
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
     * Set trial
     *
     * @param \DateTime $trial
     * @return Orders
     */
    public function setTrial($trial)
    {
        $this->trial = $trial;
    
        return $this;
    }

    /**
     * Get trial
     *
     * @return \DateTime 
     */
    public function getTrial()
    {
        return $this->trial;
    }

    /**
     * Set quote
     *
     * @param float $quote
     * @return Orders
     */
    public function setQuote($quote)
    {
        $this->quote = $quote;
    
        return $this;
    }

    /**
     * Get quote
     *
     * @return float 
     */
    public function getQuote()
    {
        return $this->quote;
    }

    /**
     * Set pieces
     *
     * @param integer $pieces
     * @return Orders
     */
    public function setPieces($pieces)
    {
        $this->pieces = $pieces;
    
        return $this;
    }

    /**
     * Get pieces
     *
     * @return integer 
     */
    public function getPieces()
    {
        return $this->pieces;
    }

    /**
     * Set shrinkage
     *
     * @param string $shrinkage
     * @return Orders
     */
    public function setShrinkage($shrinkage)
    {
        $this->shrinkage = $shrinkage;
    
        return $this;
    }

    /**
     * Get shrinkage
     *
     * @return string 
     */
    public function getShrinkage()
    {
        return $this->shrinkage;
    }

    /**
     * Set press_id
     *
     * @param integer $pressId
     * @return Orders
     */
    public function setPressId($pressId)
    {
        $this->press_id = $pressId;
    
        return $this;
    }

    /**
     * Get press_id
     *
     * @return integer 
     */
    public function getPressId()
    {
        return $this->press_id;
    }

    /**
     * Set material_id
     *
     * @param integer $materialId
     * @return Orders
     */
    public function setMaterialId($materialId)
    {
        $this->material_id = $materialId;
    
        return $this;
    }

    /**
     * Get material_id
     *
     * @return integer 
     */
    public function getMaterialId()
    {
        return $this->material_id;
    }

    /**
     * Set action_id
     *
     * @param integer $actionId
     * @return Orders
     */
    public function setActionId($actionId)
    {
        $this->action_id = $actionId;
    
        return $this;
    }

    /**
     * Get action_id
     *
     * @return integer 
     */
    public function getActionId()
    {
        return $this->action_id;
    }

    /**
     * Set mold_id
     *
     * @param integer $moldId
     * @return Orders
     */
    public function setMoldId($moldId)
    {
        $this->mold_id = $moldId;
    
        return $this;
    }

    /**
     * Get mold_id
     *
     * @return integer 
     */
    public function getMoldId()
    {
        return $this->mold_id;
    }

    /**
     * Set press
     *
     * @param \NGPP\GmsagcBundle\Entity\Press $press
     * @return Orders
     */
    public function setPress(\NGPP\GmsagcBundle\Entity\Press $press = null)
    {
        $this->press = $press;
    
        return $this;
    }

    /**
     * Get press
     *
     * @return \NGPP\GmsagcBundle\Entity\Press 
     */
    public function getPress()
    {
        return $this->press;
    }

    /**
     * Set material
     *
     * @param \NGPP\GmsagcBundle\Entity\Materials $material
     * @return Orders
     */
    public function setMaterial(\NGPP\GmsagcBundle\Entity\Materials $material = null)
    {
        $this->material = $material;
    
        return $this;
    }

    /**
     * Get material
     *
     * @return \NGPP\GmsagcBundle\Entity\Materials 
     */
    public function getMaterial()
    {
        return $this->material;
    }

    /**
     * Set action
     *
     * @param \NGPP\GmsagcBundle\Entity\Actions $action
     * @return Orders
     */
    public function setAction(\NGPP\GmsagcBundle\Entity\Actions $action = null)
    {
        $this->action = $action;
    
        return $this;
    }

    /**
     * Get action
     *
     * @return \NGPP\GmsagcBundle\Entity\Actions 
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set mold
     *
     * @param \NGPP\GmsagcBundle\Entity\Molds $mold
     * @return Orders
     */
    public function setMold(\NGPP\GmsagcBundle\Entity\Molds $mold = null)
    {
        $this->mold = $mold;
    
        return $this;
    }

    /**
     * Get mold
     *
     * @return \NGPP\GmsagcBundle\Entity\Molds 
     */
    public function getMold()
    {
        return $this->mold;
    }

    /**
     * Add comments
     *
     * @param \NGPP\GmsagcBundle\Entity\Comments $comments
     * @return Orders
     */
    public function addComment(\NGPP\GmsagcBundle\Entity\Comments $comments)
    {
        $this->comments[] = $comments;
    
        return $this;
    }

    /**
     * Remove comments
     *
     * @param \NGPP\GmsagcBundle\Entity\Comments $comments
     */
    public function removeComment(\NGPP\GmsagcBundle\Entity\Comments $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Add expenses
     *
     * @param \NGPP\GmsagcBundle\Entity\Expenses $expenses
     * @return Orders
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