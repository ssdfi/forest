<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TmpUnificados
 *
 * @ORM\Table(name="tmp_unificados", indexes={@ORM\Index(name="index_tmp_unificados_on_geom", columns={"geom"})})
 * @ORM\Entity
 */
class TmpUnificados
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="tmp_unificados_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="zona", type="string", length=255, nullable=true)
     */
    private $zona;

    /**
     * @var string
     *
     * @ORM\Column(name="anio", type="string", length=255, nullable=true)
     */
    private $anio;

    /**
     * @var string
     *
     * @ORM\Column(name="actividad", type="string", length=255, nullable=true)
     */
    private $actividad;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=255, nullable=true)
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_interno", type="string", length=255, nullable=true)
     */
    private $numeroInterno;

    /**
     * @var string
     *
     * @ORM\Column(name="anio_plantacion", type="string", length=255, nullable=true)
     */
    private $anioPlantacion;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_plantacion", type="string", length=255, nullable=true)
     */
    private $tipoPlantacion;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_titular", type="string", length=255, nullable=true)
     */
    private $codigoTitular;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_productor", type="string", length=255, nullable=true)
     */
    private $numeroProductor;

    /**
     * @var string
     *
     * @ORM\Column(name="titular", type="string", length=255, nullable=true)
     */
    private $titular;

    /**
     * @var string
     *
     * @ORM\Column(name="especie", type="string", length=255, nullable=true)
     */
    private $especie;

    /**
     * @var integer
     *
     * @ORM\Column(name="numero_plantas", type="integer", nullable=true)
     */
    private $numeroPlantas;

    /**
     * @var string
     *
     * @ORM\Column(name="superficie", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $superficie;

    /**
     * @var string
     *
     * @ORM\Column(name="inspector", type="string", length=255, nullable=true)
     */
    private $inspector;

    /**
     * @var string
     *
     * @ORM\Column(name="responsable", type="string", length=255, nullable=true)
     */
    private $responsable;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="text", nullable=true)
     */
    private $observaciones;

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
     * @var geometry
     *
     * @ORM\Column(name="geom", type="geometry", nullable=true)
     */
    private $geom;



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
     * Set zona
     *
     * @param string $zona
     *
     * @return TmpUnificados
     */
    public function setZona($zona)
    {
        $this->zona = $zona;

        return $this;
    }

    /**
     * Get zona
     *
     * @return string
     */
    public function getZona()
    {
        return $this->zona;
    }

    /**
     * Set anio
     *
     * @param string $anio
     *
     * @return TmpUnificados
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;

        return $this;
    }

    /**
     * Get anio
     *
     * @return string
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * Set actividad
     *
     * @param string $actividad
     *
     * @return TmpUnificados
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
     * Set estado
     *
     * @param string $estado
     *
     * @return TmpUnificados
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set numeroInterno
     *
     * @param string $numeroInterno
     *
     * @return TmpUnificados
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
     * Set anioPlantacion
     *
     * @param string $anioPlantacion
     *
     * @return TmpUnificados
     */
    public function setAnioPlantacion($anioPlantacion)
    {
        $this->anioPlantacion = $anioPlantacion;

        return $this;
    }

    /**
     * Get anioPlantacion
     *
     * @return string
     */
    public function getAnioPlantacion()
    {
        return $this->anioPlantacion;
    }

    /**
     * Set tipoPlantacion
     *
     * @param string $tipoPlantacion
     *
     * @return TmpUnificados
     */
    public function setTipoPlantacion($tipoPlantacion)
    {
        $this->tipoPlantacion = $tipoPlantacion;

        return $this;
    }

    /**
     * Get tipoPlantacion
     *
     * @return string
     */
    public function getTipoPlantacion()
    {
        return $this->tipoPlantacion;
    }

    /**
     * Set codigoTitular
     *
     * @param string $codigoTitular
     *
     * @return TmpUnificados
     */
    public function setCodigoTitular($codigoTitular)
    {
        $this->codigoTitular = $codigoTitular;

        return $this;
    }

    /**
     * Get codigoTitular
     *
     * @return string
     */
    public function getCodigoTitular()
    {
        return $this->codigoTitular;
    }

    /**
     * Set numeroProductor
     *
     * @param string $numeroProductor
     *
     * @return TmpUnificados
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
     * Set titular
     *
     * @param string $titular
     *
     * @return TmpUnificados
     */
    public function setTitular($titular)
    {
        $this->titular = $titular;

        return $this;
    }

    /**
     * Get titular
     *
     * @return string
     */
    public function getTitular()
    {
        return $this->titular;
    }

    /**
     * Set especie
     *
     * @param string $especie
     *
     * @return TmpUnificados
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
     * Set numeroPlantas
     *
     * @param integer $numeroPlantas
     *
     * @return TmpUnificados
     */
    public function setNumeroPlantas($numeroPlantas)
    {
        $this->numeroPlantas = $numeroPlantas;

        return $this;
    }

    /**
     * Get numeroPlantas
     *
     * @return integer
     */
    public function getNumeroPlantas()
    {
        return $this->numeroPlantas;
    }

    /**
     * Set superficie
     *
     * @param string $superficie
     *
     * @return TmpUnificados
     */
    public function setSuperficie($superficie)
    {
        $this->superficie = $superficie;

        return $this;
    }

    /**
     * Get superficie
     *
     * @return string
     */
    public function getSuperficie()
    {
        return $this->superficie;
    }

    /**
     * Set inspector
     *
     * @param string $inspector
     *
     * @return TmpUnificados
     */
    public function setInspector($inspector)
    {
        $this->inspector = $inspector;

        return $this;
    }

    /**
     * Get inspector
     *
     * @return string
     */
    public function getInspector()
    {
        return $this->inspector;
    }

    /**
     * Set responsable
     *
     * @param string $responsable
     *
     * @return TmpUnificados
     */
    public function setResponsable($responsable)
    {
        $this->responsable = $responsable;

        return $this;
    }

    /**
     * Get responsable
     *
     * @return string
     */
    public function getResponsable()
    {
        return $this->responsable;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return TmpUnificados
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return TmpUnificados
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
     * @return TmpUnificados
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
     * Set geom
     *
     * @param geometry $geom
     *
     * @return TmpUnificados
     */
    public function setGeom($geom)
    {
        $this->geom = $geom;

        return $this;
    }

    /**
     * Get geom
     *
     * @return geometry
     */
    public function getGeom()
    {
        return $this->geom;
    }
}
