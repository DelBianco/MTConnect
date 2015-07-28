<?php

namespace MTConnectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Machine
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MTConnectBundle\Entity\MachineRepository")
 */
class Machine
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
     * @ORM\Column(name="Name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="UUID", type="string", length=255, nullable=true)
     */
    private $uUID;


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
     * @return Machine
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
     * Set uUID
     *
     * @param string $uUID
     * @return Machine
     */
    public function setUUID($uUID)
    {
        $this->uUID = $uUID;

        return $this;
    }

    /**
     * Get uUID
     *
     * @return string 
     */
    public function getUUID()
    {
        return $this->uUID;
    }
}
