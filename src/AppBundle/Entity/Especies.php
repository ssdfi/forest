<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Especies
 *
 * @ORM\Table(name="especies", indexes={@ORM\Index(name="index_especies_on_codigo", columns={"codigo"}), @ORM\Index(name="index_especies_on_codigo_sp", columns={"codigo_sp"}), @ORM\Index(name="index_especies_on_genero_id", columns={"genero_id"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Especies
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="especies_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_sp", type="string", length=255, nullable=true)
     */
    private $codigoSp;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=255, nullable=true)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_cientifico", type="string", length=255, nullable=true)
     */
    private $nombreCientifico;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_comun", type="string", length=255, nullable=true)
     */
    private $nombreComun;

    /**
     * @var string
     *
     * @ORM\Column(name="inscripcion_inase", type="string", length=255, nullable=true)
     */
    private $inscripcionInase;

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
     * @var \Generos
     *
     * @ORM\ManyToOne(targetEntity="Generos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="genero_id", referencedColumnName="id")
     * })
     */
    private $genero;
    /**
      * @var ArrayCollection $plantaciones
      * @ORM\ManyToMany(targetEntity="Plantaciones",  cascade={"all"}, fetch="LAZY")
      * @ORM\JoinTable(
      *      name="especies_plantaciones",
      *      joinColumns={@ORM\JoinColumn(name="especie_id", referencedColumnName="id")},
      *      inverseJoinColumns={@ORM\JoinColumn(name="plantacion_id", referencedColumnName="id")}
      * )
      */
    private $plantacion;


    /**
     * Get Plantacion
     *
     * @return Plantacion
     */
    public function getPlantacion()
    {
        return $this->plantacion;
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set codigoSp
     *
     * @param string $codigoSp
     *
     * @return Especies
     */
    public function setCodigoSp($codigoSp)
    {
        $this->codigoSp = $codigoSp;

        return $this;
    }

    /**
     * Get codigoSp
     *
     * @return string
     */
    public function getCodigoSp()
    {
        return $this->codigoSp;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     *
     * @return Especies
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set nombreCientifico
     *
     * @param string $nombreCientifico
     *
     * @return Especies
     */
    public function setNombreCientifico($nombreCientifico)
    {
        $this->nombreCientifico = $nombreCientifico;

        return $this;
    }

    /**
     * Get nombreCientifico
     *
     * @return string
     */
    public function getNombreCientifico()
    {
        return $this->nombreCientifico;
    }

    /**
     * Set nombreComun
     *
     * @param string $nombreComun
     *
     * @return Especies
     */
    public function setNombreComun($nombreComun)
    {
        $this->nombreComun = $nombreComun;

        return $this;
    }

    /**
     * Get nombreComun
     *
     * @return string
     */
    public function getNombreComun()
    {
        return $this->nombreComun;
    }

    /**
     * Set inscripcionInase
     *
     * @param string $inscripcionInase
     *
     * @return Especies
     */
    public function setInscripcionInase($inscripcionInase)
    {
        $this->inscripcionInase = $inscripcionInase;

        return $this;
    }

    /**
     * Get inscripcionInase
     *
     * @return string
     */
    public function getInscripcionInase()
    {
        return $this->inscripcionInase;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Especies
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
     * @return Especies
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
     * Set genero
     *
     * @param \AppBundle\Entity\Generos $genero
     *
     * @return Especies
     */
    public function setGenero(\AppBundle\Entity\Generos $genero = null)
    {
        $this->genero = $genero;

        return $this;
    }

    /**
     * Get genero
     *
     * @return \AppBundle\Entity\Generos
     */
    public function getGenero()
    {
        return $this->genero;
    }

    public function __toString()
    {
        return $this->nombreCientifico;
    }
}
