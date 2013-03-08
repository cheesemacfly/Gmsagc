<?php

namespace NGPP\GmsagcBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Types
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Types
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Relations", mappedBy="types")
     */
    protected $relations;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->relations = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Types
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
     * Add relations
     *
     * @param \NGPP\GmsagcBundle\Entity\Relations $relations
     * @return Types
     */
    public function addRelation(\NGPP\GmsagcBundle\Entity\Relations $relations)
    {
        $this->relations[] = $relations;
    
        return $this;
    }

    /**
     * Remove relations
     *
     * @param \NGPP\GmsagcBundle\Entity\Relations $relations
     */
    public function removeRelation(\NGPP\GmsagcBundle\Entity\Relations $relations)
    {
        $this->relations->removeElement($relations);
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