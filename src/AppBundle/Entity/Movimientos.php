<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Movimientos
 *
 * @ORM\Table(name="movimientos", indexes={@ORM\Index(name="index_movimientos_on_reinspector_id", columns={"reinspector_id"}), @ORM\Index(name="index_movimientos_on_destino_id", columns={"destino_id"}), @ORM\Index(name="index_movimientos_on_expediente_id", columns={"expediente_id"}), @ORM\Index(name="index_movimientos_on_responsable_id", columns={"responsable_id"}), @ORM\Index(name="index_movimientos_on_inspector_id", columns={"inspector_id"}), @ORM\Index(name="index_movimientos_on_validador_id", columns={"validador_id"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Movimientos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="movimientos_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="numero_ficha", type="integer", nullable=true)
     */
    private $numeroFicha;

    /**
     * @var string
     *
     * @ORM\Column(name="anio_inspeccion", type="string", length=255, nullable=true)
     */
    private $anioInspeccion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_entrada", type="date", nullable=true)
     */
    private $fechaEntrada;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_salida", type="date", nullable=true)
     */
    private $fechaSalida;

    /**
     * @var integer
     *
     * @ORM\Column(name="etapa", type="integer", nullable=true)
     */
    private $etapa;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estabilidad_fiscal", type="boolean", nullable=true)
     */
    private $estabilidadFiscal;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="text", nullable=true)
     */
    private $observacion;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion_interna", type="text", nullable=true)
     */
    private $observacionInterna;

    /**
     * @var boolean
     *
     * @ORM\Column(name="auditar", type="boolean", nullable=true)
     */
    private $auditar;

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
     * @var \Destinos
     *
     * @ORM\ManyToOne(targetEntity="Destinos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="destino_id", referencedColumnName="id")
     * })
     */
    private $destino;

    /**
     * @var \Expedientes
     *
     * @ORM\ManyToOne(targetEntity="Expedientes", inversedBy="movimientos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="expediente_id", referencedColumnName="id")
     * })
     */
    private $expediente;

    /**
     * @var \Inspectores
     *
     * @ORM\ManyToOne(targetEntity="Inspectores")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inspector_id", referencedColumnName="id")
     * })
     */
    private $inspector;

    /**
     * @var \Inspectores
     *
     * @ORM\ManyToOne(targetEntity="Inspectores")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="reinspector_id", referencedColumnName="id")
     * })
     */
    private $reinspector;

    /**
     * @var \Responsables
     *
     * @ORM\ManyToOne(targetEntity="Responsables")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="responsable_id", referencedColumnName="id")
     * })
     */
    private $responsable;

    /**
     * @var \Responsables
     *
     * @ORM\ManyToOne(targetEntity="Responsables")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="validador_id", referencedColumnName="id")
     * })
     */
    private $validador;


    /**
    * Gets triggered only on insert

    * @ORM\PrePersist
    */
    public function onPrePersist()
    {
      $this->createdAt = new \DateTime("now");
    }

    /**
    * Gets triggered every time on update

    * @ORM\PreUpdate
    */
    public function onPreUpdate()
    {
      $this->updatedAt = new \DateTime("now");
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
     * Set numeroFicha
     *
     * @param integer $numeroFicha
     *
     * @return Movimientos
     */
    public function setNumeroFicha($numeroFicha)
    {
        $this->numeroFicha = $numeroFicha;

        return $this;
    }

    /**
     * Get numeroFicha
     *
     * @return integer
     */
    public function getNumeroFicha()
    {
        return $this->numeroFicha;
    }

    /**
     * Set anioInspeccion
     *
     * @param string $anioInspeccion
     *
     * @return Movimientos
     */
    public function setAnioInspeccion($anioInspeccion)
    {
        $this->anioInspeccion = $anioInspeccion;

        return $this;
    }

    /**
     * Get anioInspeccion
     *
     * @return string
     */
    public function getAnioInspeccion()
    {
        return $this->anioInspeccion;
    }

    /**
     * Set fechaEntrada
     *
     * @param \DateTime $fechaEntrada
     *
     * @return Movimientos
     */
    public function setFechaEntrada($fechaEntrada)
    {
        $this->fechaEntrada = $fechaEntrada;

        return $this;
    }

    /**
     * Get fechaEntrada
     *
     * @return \DateTime
     */
    public function getFechaEntrada()
    {
        return $this->fechaEntrada;
    }

    /**
     * Set fechaSalida
     *
     * @param \DateTime $fechaSalida
     *
     * @return Movimientos
     */
    public function setFechaSalida($fechaSalida)
    {
        $this->fechaSalida = $fechaSalida;

        return $this;
    }

    /**
     * Get fechaSalida
     *
     * @return \DateTime
     */
    public function getFechaSalida()
    {
        return $this->fechaSalida;
    }

    /**
     * Set etapa
     *
     * @param integer $etapa
     *
     * @return Movimientos
     */
    public function setEtapa($etapa)
    {
        $this->etapa = $etapa;

        return $this;
    }

    /**
     * Get etapa
     *
     * @return integer
     */
    public function getEtapa()
    {
        return $this->etapa;
    }

    /**
     * Set estabilidadFiscal
     *
     * @param boolean $estabilidadFiscal
     *
     * @return Movimientos
     */
    public function setEstabilidadFiscal($estabilidadFiscal)
    {
        $this->estabilidadFiscal = $estabilidadFiscal;

        return $this;
    }

    /**
     * Get estabilidadFiscal
     *
     * @return boolean
     */
    public function getEstabilidadFiscal()
    {
        return $this->estabilidadFiscal;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     *
     * @return Movimientos
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * Get observacion
     *
     * @return string
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * Set observacionInterna
     *
     * @param string $observacionInterna
     *
     * @return Movimientos
     */
    public function setObservacionInterna($observacionInterna)
    {
        $this->observacionInterna = $observacionInterna;

        return $this;
    }

    /**
     * Get observacionInterna
     *
     * @return string
     */
    public function getObservacionInterna()
    {
        return $this->observacionInterna;
    }

    /**
     * Set auditar
     *
     * @param boolean $auditar
     *
     * @return Movimientos
     */
    public function setAuditar($auditar)
    {
        $this->auditar = $auditar;

        return $this;
    }

    /**
     * Get auditar
     *
     * @return boolean
     */
    public function getAuditar()
    {
        return $this->auditar;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Movimientos
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
     * @return Movimientos
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
     * Set destino
     *
     * @param \AppBundle\Entity\Destinos $destino
     *
     * @return Movimientos
     */
    public function setDestino(\AppBundle\Entity\Destinos $destino = null)
    {
        $this->destino = $destino;

        return $this;
    }

    /**
     * Get destino
     *
     * @return \AppBundle\Entity\Destinos
     */
    public function getDestino()
    {
        return $this->destino;
    }

    /**
     * Set expediente
     *
     * @param \AppBundle\Entity\Expedientes $expediente
     *
     * @return Movimientos
     */
    public function setExpediente(\AppBundle\Entity\Expedientes $expediente = null)
    {
        $this->expediente = $expediente;

        return $this;
    }

    /**
     * Get expediente
     *
     * @return \AppBundle\Entity\Expedientes
     */
    public function getExpediente()
    {
        return $this->expediente;
    }

    /**
     * Set inspector
     *
     * @param \AppBundle\Entity\Inspectores $inspector
     *
     * @return Movimientos
     */
    public function setInspector(\AppBundle\Entity\Inspectores $inspector = null)
    {
        $this->inspector = $inspector;

        return $this;
    }

    /**
     * Get inspector
     *
     * @return \AppBundle\Entity\Inspectores
     */
    public function getInspector()
    {
        return $this->inspector;
    }

    /**
     * Set reinspector
     *
     * @param \AppBundle\Entity\Inspectores $reinspector
     *
     * @return Movimientos
     */
    public function setReinspector(\AppBundle\Entity\Inspectores $reinspector = null)
    {
        $this->reinspector = $reinspector;

        return $this;
    }

    /**
     * Get reinspector
     *
     * @return \AppBundle\Entity\Inspectores
     */
    public function getReinspector()
    {
        return $this->reinspector;
    }

    /**
     * Set responsable
     *
     * @param \AppBundle\Entity\Responsables $responsable
     *
     * @return Movimientos
     */
    public function setResponsable(\AppBundle\Entity\Responsables $responsable = null)
    {
        $this->responsable = $responsable;

        return $this;
    }

    /**
     * Get responsable
     *
     * @return \AppBundle\Entity\Responsables
     */
    public function getResponsable()
    {
        return $this->responsable;
    }

    /**
     * Set validador
     *
     * @param \AppBundle\Entity\Responsables $validador
     *
     * @return Movimientos
     */
    public function setValidador(\AppBundle\Entity\Responsables $validador = null)
    {
        $this->validador = $validador;

        return $this;
    }

    /**
     * Get validador
     *
     * @return \AppBundle\Entity\Responsables
     */
    public function getValidador()
    {
        return $this->validador;
    }
}
