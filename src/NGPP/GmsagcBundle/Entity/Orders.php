<?php

namespace NGPP\GmsagcBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Orders
 *
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
     * @Assert\Type(type="\DateTime")
     */
    private $oral;

    /**
     * @var \Date
     *
     * @ORM\Column(name="written", type="date", nullable=true)
     * @Assert\Type(type="\DateTime")
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
     * @Assert\Type(type="\DateTime")
     */
    private $trial;

    /**
     * @var float
     *
     * @ORM\Column(name="quote", type="decimal", precision=12, scale=2)
     * @Assert\NotBlank()
     */
    private $quote;

    /**
     * @var integer
     *
     * @ORM\Column(name="pieces", type="integer", nullable=true)
     * @Assert\Type(type="integer")
     */
    private $pieces;

    /**
     * @var string
     *
     * @ORM\Column(name="shrinkage", type="string", length=255, nullable=true)
     */
    private $shrinkage;
    
    /**
     * @ORM\ManyToOne(targetEntity="Press", inversedBy="orders", cascade={"persist"})
     */
    protected $press;
    
    /**
     * @ORM\ManyToOne(targetEntity="Materials", inversedBy="orders", cascade={"persist"})
     */
    protected $material;
    
    /**
     * @ORM\ManyToOne(targetEntity="Actions")
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
     * @ORM\OneToMany(targetEntity="Relations", mappedBy="order", cascade={"persist"})
     */
    protected $relations;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->expenses = new ArrayCollection();
        $this->relations = new ArrayCollection();
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
    public function setOral(\DateTime $oral = null)
    {
        $this->oral = $oral ? clone $oral : null;
    
        return $this;
    }

    /**
     * Get oral
     *
     * @return \DateTime 
     */
    public function getOral()
    {
        return $this->oral ? clone $this->oral : null;
    }

    /**
     * Set written
     *
     * @param \DateTime $written
     * @return Orders
     */
    public function setWritten(\DateTime $written = null)
    {
        $this->written = $written ? clone $written : null;
    
        return $this;
    }

    /**
     * Get written
     *
     * @return \DateTime 
     */
    public function getWritten()
    {
        return $this->written ? clone $this->written : null;
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
    public function setTrial(\DateTime $trial = null)
    {
        $this->trial = $trial ? clone $trial : null;
    
        return $this;
    }

    /**
     * Get trial
     *
     * @return \DateTime 
     */
    public function getTrial()
    {
        return $this->trial ? clone $this->trial: null;
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
     * Set press
     *
     * @param \NGPP\GmsagcBundle\Entity\Press $press
     * @return Orders
     */
    public function setPress(Press $press = null)
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
    public function setMaterial(Materials $material = null)
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
    public function setAction(Actions $action = null)
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
    public function setMold(Molds $mold = null)
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
    public function addComment(Comments $comments)
    {
        $this->comments[] = $comments;
    
        return $this;
    }

    /**
     * Remove comments
     *
     * @param \NGPP\GmsagcBundle\Entity\Comments $comments
     */
    public function removeComment(Comments $comments)
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
    public function addExpense(Expenses $expenses)
    {
        $this->expenses[] = $expenses;
    
        return $this;
    }

    /**
     * Remove expenses
     *
     * @param \NGPP\GmsagcBundle\Entity\Expenses $expenses
     */
    public function removeExpense(Expenses $expenses)
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

    /**
     * Add relations
     *
     * @param \NGPP\GmsagcBundle\Entity\Relations $relations
     * @return Orders
     */
    public function addRelations(Relations $relations)
    {
        $this->relations[] = $relations;

        return $this;
    }

    /**
     * Remove relations
     *
     * @param \NGPP\GmsagcBundle\Entity\Relations $relations
     */
    public function removeRelations(Relations $relations)
    {
        $this->relations->removeElement($relations);
    }

    /**
     * Set relations
     * 
     * @param \Doctrine\Common\Collections\ArrayCollection $relations
     */
    public function setRelations($relations)
    {
        foreach ($relations as $relation) {
            $relation->setOrder($this);
        }

        $this->relations = $relations;
    }
    
    /**
     * Get relations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRelations()
    {
        return $this->relations;
    }
}
