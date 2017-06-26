<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ActividadesTitulares
 *
 * @ORM\Table(name="actividades_titulares", indexes={@ORM\Index(name="index_actividades_titulares_on_especie_id", columns={"especie_id"}), @ORM\Index(name="index_actividades_titulares_on_titular_id", columns={"titular_id"}), @ORM\Index(name="index_actividades_titulares_on_tipo_plantacion_id", columns={"tipo_plantacion_id"}), @ORM\Index(name="index_actividades_titulares_on_actividad_id", columns={"actividad_id"})})
 * @ORM\Entity
 */
class ActividadesTitulares
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="actividades_titulares_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="superficie_presentada", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $superficiePresentada;

    /**
     * @var string
     *
     * @ORM\Column(name="superficie_certificada", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $superficieCertificada;

    /**
     * @var string
     *
     * @ORM\Column(name="superficie_inspeccionada", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $superficieInspeccionada;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="text", nullable=true)
     */
    private $observaciones;

    /**
     * @var \Actividades
     *
     * @ORM\ManyToOne(targetEntity="Actividades", inversedBy="actividadesTitulares")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="actividad_id", referencedColumnName="id")
     * })
     */
    private $actividad;

    /**
     * @var \Titulares
     *
     * @ORM\ManyToOne(targetEntity="Titulares")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="titular_id", referencedColumnName="id")
     * })
     */
    private $titular;

    /**
     * @var \TiposPlantacion
     *
     * @ORM\ManyToOne(targetEntity="TiposPlantacion", fetch = "LAZY")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_plantacion_id", referencedColumnName="id")
     * })
     */
    private $tipoPlantacion;

    /**
     * @var \Especies
     *
     * @ORM\ManyToOne(targetEntity="Especies", fetch="LAZY")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="especie_id", referencedColumnName="id")
     * })
     */
    private $especie;


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
     * Set superficiePresentada
     *
     * @param string $superficiePresentada
     *
     * @return ActividadesTitulares
     */
    public function setSuperficiePresentada($superficiePresentada)
    {
        $this->superficiePresentada = $superficiePresentada;

        return $this;
    }

    /**
     * Get superficiePresentada
     *
     * @return string
     */
    public function getSuperficiePresentada()
    {
        return $this->superficiePresentada;
    }

    /**
     * Set superficieCertificada
     *
     * @param string $superficieCertificada
     *
     * @return ActividadesTitulares
     */
    public function setSuperficieCertificada($superficieCertificada)
    {
        $this->superficieCertificada = $superficieCertificada;

        return $this;
    }

    /**
     * Get superficieCertificada
     *
     * @return string
     */
    public function getSuperficieCertificada()
    {
        return $this->superficieCertificada;
    }

    /**
     * Set superficieInspeccionada
     *
     * @param string $superficieInspeccionada
     *
     * @return ActividadesTitulares
     */
    public function setSuperficieInspeccionada($superficieInspeccionada)
    {
        $this->superficieInspeccionada = $superficieInspeccionada;

        return $this;
    }

    /**
     * Get superficieInspeccionada
     *
     * @return string
     */
    public function getSuperficieInspeccionada()
    {
        return $this->superficieInspeccionada;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return ActividadesTitulares
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
     * Set actividad
     *
     * @param \AppBundle\Entity\Actividades $actividad
     *
     * @return ActividadesTitulares
     */
    public function setActividad(\AppBundle\Entity\Actividades $actividad = null)
    {
        $this->actividad = $actividad;

        return $this;
    }

    /**
     * Get actividad
     *
     * @return \AppBundle\Entity\Actividades
     */
    public function getActividad()
    {
        return $this->actividad;
    }

    /**
     * Set titular
     *
     * @param \AppBundle\Entity\Titulares $titular
     *
     * @return ActividadesTitulares
     */
    public function setTitular(\AppBundle\Entity\Titulares $titular = null)
    {
        $this->titular = $titular;

        return $this;
    }

    /**
     * Get titular
     *
     * @return \AppBundle\Entity\Titulares
     */
    public function getTitular()
    {
        return $this->titular;
    }

    /**
     * Set tipoPlantacion
     *
     * @param \AppBundle\Entity\TiposPlantacion $tipoPlantacion
     *
     * @return ActividadesTitulares
     */
    public function setTipoPlantacion(\AppBundle\Entity\TiposPlantacion $tipoPlantacion = null)
    {
        $this->tipoPlantacion = $tipoPlantacion;

        return $this;
    }

    /**
     * Get tipoPlantacion
     *
     * @return \AppBundle\Entity\TiposPlantacion
     */
    public function getTipoPlantacion()
    {
        return $this->tipoPlantacion;
    }

    /**
     * Set especie
     *
     * @param \AppBundle\Entity\Especies $especie
     *
     * @return ActividadesTitulares
     */
    public function setEspecie(\AppBundle\Entity\Especies $especie = null)
    {
        $this->especie = $especie;

        return $this;
    }

    /**
     * Get especie
     *
     * @return \AppBundle\Entity\Especies
     */
    public function getEspecie()
    {
        return $this->especie;
    }
}
