<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Expedientes
 *
 * @ORM\Table(name="expedientes", indexes={@ORM\Index(name="index_expedientes_on_tecnico_id", columns={"tecnico_id"}), @ORM\Index(name="index_expedientes_on_zona_departamento_id", columns={"zona_departamento_id"}), @ORM\Index(name="index_expedientes_on_zona_id", columns={"zona_id"}), @ORM\Index(name="index_expedientes_on_numero_expediente", columns={"numero_expediente"}), @ORM\Index(name="index_expedientes_on_numero_interno", columns={"numero_interno"})})
 * @ORM\Entity
 */
class Expedientes
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="expedientes_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_interno", type="string", length=255, nullable=true)
     */
    private $numeroInterno;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_expediente", type="string", length=255, nullable=true)
     */
    private $numeroExpediente;

    /**
     * @var boolean
     *
     * @ORM\Column(name="agrupado", type="boolean", nullable=true)
     */
    private $agrupado;

    /**
     * @var boolean
     *
     * @ORM\Column(name="plurianual", type="boolean", nullable=true)
     */
    private $plurianual;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean", nullable=true)
     */
    private $activo;

    /**
     * @var integer
     *
     * @ORM\Column(name="anio", type="integer", nullable=true)
     */
    private $anio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var \ZonaDepartamentos
     *
     * @ORM\ManyToOne(targetEntity="ZonaDepartamentos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="zona_departamento_id", referencedColumnName="id")
     * })
     */
    private $zonaDepartamento;

    /**
     * @var \Tecnicos
     *
     * @ORM\ManyToOne(targetEntity="Tecnicos", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tecnico_id", referencedColumnName="id")
     * })
     */
    private $tecnico;

    /**
     * @var \Zonas
     *
     * @ORM\ManyToOne(targetEntity="Zonas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="zona_id", referencedColumnName="id")
     * })
     */
    private $zona;



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
     * Set numeroInterno
     *
     * @param string $numeroInterno
     *
     * @return Expedientes
     */
    public function setNumeroInterno($numeroInterno)
    {
        $this->numeroInterno = $numeroInterno;

        return $this;
    }

    /**
     * Get numeroInterno
     *
     * @return string
     */
    public function getNumeroInterno()
    {
        return $this->numeroInterno;
    }

    /**
     * Set numeroExpediente
     *
     * @param string $numeroExpediente
     *
     * @return Expedientes
     */
    public function setNumeroExpediente($numeroExpediente)
    {
        $this->numeroExpediente = $numeroExpediente;

        return $this;
    }

    /**
     * Get numeroExpediente
     *
     * @return string
     */
    public function getNumeroExpediente()
    {
        return $this->numeroExpediente;
    }

    /**
     * Set agrupado
     *
     * @param boolean $agrupado
     *
     * @return Expedientes
     */
    public function setAgrupado($agrupado)
    {
        $this->agrupado = $agrupado;

        return $this;
    }

    /**
     * Get agrupado
     *
     * @return boolean
     */
    public function getAgrupado()
    {
        return $this->agrupado;
    }

    /**
     * Set plurianual
     *
     * @param boolean $plurianual
     *
     * @return Expedientes
     */
    public function setPlurianual($plurianual)
    {
        $this->plurianual = $plurianual;

        return $this;
    }

    /**
     * Get plurianual
     *
     * @return boolean
     */
    public function getPlurianual()
    {
        return $this->plurianual;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Expedientes
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set anio
     *
     * @param integer $anio
     *
     * @return Expedientes
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;

        return $this;
    }

    /**
     * Get anio
     *
     * @return integer
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Expedientes
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Expedientes
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set zonaDepartamento
     *
     * @param \AppBundle\Entity\ZonaDepartamentos $zonaDepartamento
     *
     * @return Expedientes
     */
    public function setZonaDepartamento(\AppBundle\Entity\ZonaDepartamentos $zonaDepartamento = null)
    {
        $this->zonaDepartamento = $zonaDepartamento;

        return $this;
    }

    /**
     * Get zonaDepartamento
     *
     * @return \AppBundle\Entity\ZonaDepartamentos
     */
    public function getZonaDepartamento()
    {
        return $this->zonaDepartamento;
    }

    /**
     * Set tecnico
     *
     * @param \AppBundle\Entity\Tecnicos $tecnico
     *
     * @return Expedientes
     */
    public function setTecnico(\AppBundle\Entity\Tecnicos $tecnico = null)
    {
        $this->tecnico = $tecnico;

        return $this;
    }

    /**
     * Get tecnico
     *
     * @return \AppBundle\Entity\Tecnicos
     */
    public function getTecnico()
    {
        return $this->tecnico;
    }

    /**
     * Set zona
     *
     * @param \AppBundle\Entity\Zonas $zona
     *
     * @return Expedientes
     */
    public function setZona(\AppBundle\Entity\Zonas $zona = null)
    {
        $this->zona = $zona;

        return $this;
    }

    /**
     * Get zona
     *
     * @return \AppBundle\Entity\Zonas
     */
    public function getZona()
    {
        return $this->zona;
    }


    public function __construct() {
        $this->tecnico = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
