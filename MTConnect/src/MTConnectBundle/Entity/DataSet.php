<?php

namespace MTConnectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne as ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn as JoinColumn;

/**
 * DataSet
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MTConnectBundle\Entity\DataSetRepository")
 */
class DataSet
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
     * @ManyToOne(targetEntity="Coleta")
     * @(name="coleta", referencedColumnName="id")
     **/
    private $coleta;

    /**
     * @var integer
     *
     * @ORM\Column(name="sequence", type="integer")
     */
    private $sequence;


    /**
     * @var string
     *
     * @ORM\Column(name="dataItem_name", type="string")
     */
    private $dataItem_name;

    /**
     * @ManyToOne(targetEntity="DataItem")
     * @(name="dataItem", referencedColumnName="id", nullable=true)
     **/
    private $dataItem;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestamp", type="datetime")
     */
    private $timestamp;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255)
     */
    private $value;


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
     * Set Coleta
     *
     * @param Coleta $coleta
     * @return DataSet
     */
    public function setColeta($coleta)
    {
        $this->coleta = $coleta;

        return $this;
    }

    /**
     * Get coleta
     *
     * @return Coleta
     */
    public function getColeta()
    {
        return $this->coleta;
    }

    /**
     * Set dataItem
     *
     * @param integer $dataItem
     * @return DataSet
     */
    public function setDataItem($dataItem)
    {
        $this->dataItem = $dataItem;

        return $this;
    }

    /**
     * Get dataItem
     *
     * @return integer 
     */
    public function getDataItem()
    {
        return $this->dataItem;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return DataSet
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime 
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return DataSet
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return int
     */
    public function getSequence()
    {
        return $this->sequence;
    }

    /**
     * @param int $sequence
     */
    public function setSequence($sequence)
    {
        $this->sequence = $sequence;
    }

    /**
     * @return mixed
     */
    public function getDataItemName()
    {
        return $this->dataItem_name;
    }

    /**
     * @param mixed $dataItem_name
     */
    public function setDataItemName($dataItem_name)
    {
        $this->dataItem_name = $dataItem_name;
    }


}
