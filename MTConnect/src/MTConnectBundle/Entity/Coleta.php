<?php

namespace MTConnectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Coleta
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MTConnectBundle\Entity\ColetaRepository")
 */
class Coleta
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
     * @ORM\Column(name="nome", type="string", length=255)
     */
    private $nome;

    /**
     * @var array
     *
     * @ORM\Column(name="dataItems", type="array", nullable=true)
     */
    private $dataItems;

    /**
     * @var string
     *
     * @ORM\Column(name="probe", type="text")
     */
    private $probe;

    /**
     * @var integer
     *
     * @ORM\Column(name="numDeColetas", type="integer", nullable=true)
     */
    private $numDeColetas;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataDeCriacao", type="datetime")
     */
    private $dataDeCriacao;


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
     * Set nome
     *
     * @param string $nome
     * @return Coleta
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string 
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set dataItems
     *
     * @param array $dataItems
     * @return Coleta
     */
    public function setDataItems($dataItems)
    {
        $this->dataItems = $dataItems;

        return $this;
    }

    /**
     * Get dataItems
     *
     * @return array 
     */
    public function getDataItems()
    {
        return $this->dataItems;
    }

    /**
     * Set probe
     *
     * @param string $probe
     * @return Coleta
     */
    public function setProbe($probe)
    {
        $this->probe = $probe;

        return $this;
    }

    /**
     * Get probe
     *
     * @return string 
     */
    public function getProbe()
    {
        return $this->probe;
    }

    /**
     * Set numDeColetas
     *
     * @param integer $numDeColetas
     * @return Coleta
     */
    public function setNumDeColetas($numDeColetas)
    {
        $this->numDeColetas = $numDeColetas;

        return $this;
    }

    /**
     * Get numDeColetas
     *
     * @return integer 
     */
    public function getNumDeColetas()
    {
        return $this->numDeColetas;
    }

    /**
     * Set dataDeCriacao
     *
     * @param \DateTime $dataDeCriacao
     * @return Coleta
     */
    public function setDataDeCriacao($dataDeCriacao)
    {
        $this->dataDeCriacao = $dataDeCriacao;

        return $this;
    }

    /**
     * Get dataDeCriacao
     *
     * @return \DateTime 
     */
    public function getDataDeCriacao()
    {
        return $this->dataDeCriacao;
    }
}
