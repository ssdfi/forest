<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ZonaDepartamentos
 *
 * @ORM\Table(name="zona_departamentos", indexes={@ORM\Index(name="index_zona_departamentos_on_zona_id", columns={"zona_id"}), @ORM\Index(name="index_zona_departamentos_on_codigo", columns={"codigo"})})
 * @ORM\Entity
 */
class ZonaDepartamentos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="zona_departamentos_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=255, nullable=true)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_indec", type="string", length=255, nullable=true)
     */
    private $codigoIndec;

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
     * Set codigo
     *
     * @param string $codigo
     *
     * @return ZonaDepartamentos
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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return ZonaDepartamentos
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set codigoIndec
     *
     * @param string $codigoIndec
     *
     * @return ZonaDepartamentos
     */
    public function setCodigoIndec($codigoIndec)
    {
        $this->codigoIndec = $codigoIndec;

        return $this;
    }

    /**
     * Get codigoIndec
     *
     * @return string
     */
    public function getCodigoIndec()
    {
        return $this->codigoIndec;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return ZonaDepartamentos
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
     * @return ZonaDepartamentos
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
     * Set zona
     *
     * @param \AppBundle\Entity\Zonas $zona
     *
     * @return ZonaDepartamentos
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
    public function __toString(){
        return $this->descripcion;
    }
}
