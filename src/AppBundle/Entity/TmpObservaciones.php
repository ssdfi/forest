<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TmpObservaciones
 *
 * @ORM\Table(name="tmp_observaciones", indexes={@ORM\Index(name="index_tmp_observaciones_on_productor", columns={"productor"}), @ORM\Index(name="index_tmp_observaciones_on_numero_productor", columns={"numero_productor"}), @ORM\Index(name="index_tmp_observaciones_on_dni", columns={"dni"}), @ORM\Index(name="index_tmp_observaciones_on_numero_interno", columns={"numero_interno"}), @ORM\Index(name="index_tmp_observaciones_on_cuit", columns={"cuit"})})
 * @ORM\Entity
 */
class TmpObservaciones
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="tmp_observaciones_id_seq", allocationSize=1, initialValue=1)
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
     * @ORM\Column(name="numero_productor", type="string", length=255, nullable=true)
     */
    private $numeroProductor;

    /**
     * @var string
     *
     * @ORM\Column(name="productor", type="string", length=255, nullable=true)
     */
    private $productor;

    /**
     * @var string
     *
     * @ORM\Column(name="presentado", type="string", length=255, nullable=true)
     */
    private $presentado;

    /**
     * @var string
     *
     * @ORM\Column(name="certificado", type="string", length=255, nullable=true)
     */
    private $certificado;

    /**
     * @var string
     *
     * @ORM\Column(name="inspeccionado", type="string", length=255, nullable=true)
     */
    private $inspeccionado;

    /**
     * @var string
     *
     * @ORM\Column(name="registrado", type="string", length=255, nullable=true)
     */
    private $registrado;

    /**
     * @var string
     *
     * @ORM\Column(name="especie", type="string", length=255, nullable=true)
     */
    private $especie;

    /**
     * @var string
     *
     * @ORM\Column(name="actividad", type="string", length=255, nullable=true)
     */
    private $actividad;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=255, nullable=true)
     */
    private $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="text", nullable=true)
     */
    private $observaciones;

    /**
     * @var string
     *
     * @ORM\Column(name="dni", type="string", length=255, nullable=true)
     */
    private $dni;

    /**
     * @var string
     *
     * @ORM\Column(name="cuit", type="string", length=255, nullable=true)
     */
    private $cuit;



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
     * @return TmpObservaciones
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
     * Set numeroProductor
     *
     * @param string $numeroProductor
     *
     * @return TmpObservaciones
     */
    public function setNumeroProductor($numeroProductor)
    {
        $this->numeroProductor = $numeroProductor;

        return $this;
    }

    /**
     * Get numeroProductor
     *
     * @return string
     */
    public function getNumeroProductor()
    {
        return $this->numeroProductor;
    }

    /**
     * Set productor
     *
     * @param string $productor
     *
     * @return TmpObservaciones
     */
    public function setProductor($productor)
    {
        $this->productor = $productor;

        return $this;
    }

    /**
     * Get productor
     *
     * @return string
     */
    public function getProductor()
    {
        return $this->productor;
    }

    /**
     * Set presentado
     *
     * @param string $presentado
     *
     * @return TmpObservaciones
     */
    public function setPresentado($presentado)
    {
        $this->presentado = $presentado;

        return $this;
    }

    /**
     * Get presentado
     *
     * @return string
     */
    public function getPresentado()
    {
        return $this->presentado;
    }

    /**
     * Set certificado
     *
     * @param string $certificado
     *
     * @return TmpObservaciones
     */
    public function setCertificado($certificado)
    {
        $this->certificado = $certificado;

        return $this;
    }

    /**
     * Get certificado
     *
     * @return string
     */
    public function getCertificado()
    {
        return $this->certificado;
    }

    /**
     * Set inspeccionado
     *
     * @param string $inspeccionado
     *
     * @return TmpObservaciones
     */
    public function setInspeccionado($inspeccionado)
    {
        $this->inspeccionado = $inspeccionado;

        return $this;
    }

    /**
     * Get inspeccionado
     *
     * @return string
     */
    public function getInspeccionado()
    {
        return $this->inspeccionado;
    }

    /**
     * Set registrado
     *
     * @param string $registrado
     *
     * @return TmpObservaciones
     */
    public function setRegistrado($registrado)
    {
        $this->registrado = $registrado;

        return $this;
    }

    /**
     * Get registrado
     *
     * @return string
     */
    public function getRegistrado()
    {
        return $this->registrado;
    }

    /**
     * Set especie
     *
     * @param string $especie
     *
     * @return TmpObservaciones
     */
    public function setEspecie($especie)
    {
        $this->especie = $especie;

        return $this;
    }

    /**
     * Get especie
     *
     * @return string
     */
    public function getEspecie()
    {
        return $this->especie;
    }

    /**
     * Set actividad
     *
     * @param string $actividad
     *
     * @return TmpObservaciones
     */
    public function setActividad($actividad)
    {
        $this->actividad = $actividad;

        return $this;
    }

    /**
     * Get actividad
     *
     * @return string
     */
    public function getActividad()
    {
        return $this->actividad;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     *
     * @return TmpObservaciones
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return TmpObservaciones
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set dni
     *
     * @param string $dni
     *
     * @return TmpObservaciones
     */
    public function setDni($dni)
    {
        $this->dni = $dni;

        return $this;
    }

    /**
     * Get dni
     *
     * @return string
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set cuit
     *
     * @param string $cuit
     *
     * @return TmpObservaciones
     */
    public function setCuit($cuit)
    {
        $this->cuit = $cuit;

        return $this;
    }

    /**
     * Get cuit
     *
     * @return string
     */
    public function getCuit()
    {
        return $this->cuit;
    }
}
