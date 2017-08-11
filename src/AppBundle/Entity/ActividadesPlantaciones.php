<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ActividadesPlantaciones
 *
 * @ORM\Table(name="actividades_plantaciones", indexes={@ORM\Index(name="index_actividades_plantaciones_on_plantacion_id", columns={"plantacion_id"}), @ORM\Index(name="index_actividades_plantaciones_on_actividad_id", columns={"actividad_id"}), @ORM\Index(name="index_actividades_plantaciones_on_estado_aprobacion_id", columns={"estado_aprobacion_id"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class ActividadesPlantaciones
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="actividades_plantaciones_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="superficie_registrada", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $superficieRegistrada;

    /**
     * @var integer
     *
     * @ORM\Column(name="numero_plantas", type="integer", nullable=true)
     */
    private $numeroPlantas;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date", nullable=true)
     */
    private $fecha;

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
     * @var \Actividades
     *
     * @ORM\ManyToOne(targetEntity="Actividades", inversedBy="plantaciones", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="actividad_id", referencedColumnName="id")
     * })
     */
    private $actividad;

    /**
     * @var \EstadosAprobacion
     *
     * @ORM\ManyToOne(targetEntity="EstadosAprobacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="estado_aprobacion_id", referencedColumnName="id")
     * })
     */
    private $estadoAprobacion;

    /**
     * @var \Plantaciones
     *
     * @ORM\ManyToOne(targetEntity="Plantaciones", inversedBy="actividad", cascade={"persist","merge", "refresh", "remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="plantacion_id", referencedColumnName="id")
     * })
     */
    private $plantacion;



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
     * Set superficieRegistrada
     *
     * @param string $superficieRegistrada
     *
     * @return ActividadesPlantaciones
     */
    public function setSuperficieRegistrada($superficieRegistrada)
    {
        $this->superficieRegistrada = $superficieRegistrada;

        return $this;
    }


    /**
     * Set setActividad
     *
     * @param string $actividad
     *
     * @return ActividadesPlantaciones
     */
    public function setActividad($actividad)
    {
        $this->actividad = $actividad;
        return $this;
    }
    /**
     * Get superficieRegistrada
     *
     * @return string
     */
    public function getSuperficieRegistrada()
    {
        return $this->superficieRegistrada;
    }

    /**
     * Set numeroPlantas
     *
     * @param integer $numeroPlantas
     *
     * @return ActividadesPlantaciones
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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return ActividadesPlantaciones
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return ActividadesPlantaciones
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return ActividadesPlantaciones
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
     * @return ActividadesPlantaciones
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
     * Set actividad
     *
     * @param \AppBundle\Entity\Actividades $actividad
     *
     * @return ActividadesPlantaciones
     */
    public function addActividad(\AppBundle\Entity\Actividades $actividad = null)
    {
        $this->actividad = $actividad;
        return $this;
    }

    /**
     * Delete actividad
     *
     * @param \AppBundle\Entity\Actividades $actividad
     *
     * @return ActividadesPlantaciones
     */
    public function removeActividad(\AppBundle\Entity\Actividades $actividad = null)
    {
      if (false === $this->actividad->contains($actividad)) {
          return;
      }
      $this->actividad->removeElement($actividad);
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
     * Set estadoAprobacion
     *
     * @param \AppBundle\Entity\EstadosAprobacion $estadoAprobacion
     *
     * @return ActividadesPlantaciones
     */
    public function setEstadoAprobacion(\AppBundle\Entity\EstadosAprobacion $estadoAprobacion = null)
    {
        $this->estadoAprobacion = $estadoAprobacion;

        return $this;
    }

    /**
     * Get estadoAprobacion
     *
     * @return \AppBundle\Entity\EstadosAprobacion
     */
    public function getEstadoAprobacion()
    {
        return $this->estadoAprobacion;
    }

    /**
     * Set plantacion
     *
     * @param \AppBundle\Entity\Plantaciones $plantacion
     *
     * @return ActividadesPlantaciones
     */
    public function setPlantacion(\AppBundle\Entity\Plantaciones $plantacion)
    {
        $this->plantacion = $plantacion;

        return $this->plantacion;
    }

    /**
     * Get plantacion
     *
     * @return \AppBundle\Entity\Plantaciones
     */
    public function getPlantacion()
    {
        return $this->plantacion;
    }

    public function __toString(){
        return '$this->observaciones';
    }

}
