<?php

namespace AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;
/**
 * Actividades
 *
 * @ORM\Table(name="actividades", indexes={@ORM\Index(name="index_actividades_on_tipo_actividad_id", columns={"tipo_actividad_id"}), @ORM\Index(name="index_actividades_on_movimiento_id", columns={"movimiento_id"})})
 * @ORM\Entity
 */
class Actividades
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="actividades_id_seq", allocationSize=1, initialValue=1)
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
     * @ORM\Column(name="superficie_registrada", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $superficieRegistrada;

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
     * @var \Movimientos
     *
     * @ORM\ManyToOne(targetEntity="Movimientos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="movimiento_id", referencedColumnName="id")
     * })
     */
    private $movimiento;

    /**
     * @var \TiposActividad
     *
     * @ORM\ManyToOne(targetEntity="TiposActividad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_actividad_id", referencedColumnName="id")
     * })
     */
    private $tipoActividad;

    /**
        * @ORM\OneToMany(targetEntity="ActividadesPlantaciones",mappedBy="actividad",fetch="LAZY",cascade={"persist","remove"}, orphanRemoval=false)
        * @ORM\JoinTable(
        *      name="actividades_plantaciones",
        *      joinColumns={@ORM\JoinColumn(name="actividad_id", referencedColumnName="id")},
        *      inverseJoinColumns={@ORM\JoinColumn(name="plantacion_id", referencedColumnName="id")}
        * )
        */
    private $plantaciones;

    /**
        * @ORM\OneToMany(targetEntity="ActividadesTitulares",mappedBy="actividad",fetch="LAZY")
        * @ORM\JoinColumns({
        *   @ORM\JoinColumn(name="tipo_actividad_id", referencedColumnName="id")
        * })
        */
    private $actividadesTitulares;

    public function __construct() {
      $this->plantaciones = new ArrayCollection();
    }

    public function getActividadesTitulares()
    {
        return $this->actividadesTitulares;
    }

    public function getPlantaciones()
    {
        return $this->plantaciones;
    }

    public function addPlantacione($plantacion){
      if (true === $this->plantaciones->contains($plantacion)) {
         return;
       }
       $plantacion->setActividad($this);
       $this->plantaciones[]=$plantacion;
    }

    public function removePlantacione($plantacion){
      if (true === $this->plantaciones->contains($plantacion->getActividad())) {
          return;
      }
      $this->plantaciones->removeElement($plantacion);

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
     * Set superficiePresentada
     *
     * @param string $superficiePresentada
     *
     * @return Actividades
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
     * @return Actividades
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
     * @return Actividades
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
     * Set superficieRegistrada
     *
     * @param string $superficieRegistrada
     *
     * @return Actividades
     */
    public function setSuperficieRegistrada($superficieRegistrada)
    {
        $this->superficieRegistrada = $superficieRegistrada;

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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Actividades
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
     * @return Actividades
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
     * Set movimiento
     *
     * @param \AppBundle\Entity\Movimientos $movimiento
     *
     * @return Actividades
     */
    public function setMovimiento(\AppBundle\Entity\Movimientos $movimiento = null)
    {
        $this->movimiento = $movimiento;

        return $this;
    }

    /**
     * Get movimiento
     *
     * @return \AppBundle\Entity\Movimientos
     */
    public function getMovimiento()
    {
        return $this->movimiento;
    }

    /**
     * Set tipoActividad
     *
     * @param \AppBundle\Entity\TiposActividad $tipoActividad
     *
     * @return Actividades
     */
    public function setTipoActividad(\AppBundle\Entity\TiposActividad $tipoActividad = null)
    {
        $this->tipoActividad = $tipoActividad;

        return $this;
    }

    /**
     * Get tipoActividad
     *
     * @return \AppBundle\Entity\TiposActividad
     */
    public function getTipoActividad()
    {
        return $this->tipoActividad;
    }

    public function getSupTotalSuma() {
      $total = 0;
      foreach ($this->plantaciones as $key => $value) {
        $total += $value->getSuperficieRegistrada();
      }
      return $total;
    }
}
