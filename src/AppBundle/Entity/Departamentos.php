<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Departamentos
 *
 * @ORM\Table(name="departamentos", indexes={@ORM\Index(name="index_departamentos_on_codigo", columns={"codigo"}), @ORM\Index(name="index_departamentos_on_provincia_id", columns={"provincia_id"}), @ORM\Index(name="index_departamentos_on_nombre", columns={"nombre"}), @ORM\Index(name="index_departamentos_on_geom", columns={"geom"})})
 * @ORM\Entity
 */
class Departamentos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="departamentos_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=255, nullable=true)
     */
    private $codigo;


    /**
     * @var \Provincias
     *
     * @ORM\ManyToOne(targetEntity="Provincias")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="provincia_id", referencedColumnName="id")
     * })
     */
    private $provincia;



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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Departamentos
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     *
     * @return Departamentos
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
     * Set geom
     *
     * @param geometry $geom
     *
     * @return Departamentos
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

    /**
     * Set provincia
     *
     * @param \AppBundle\Entity\Provincias $provincia
     *
     * @return Departamentos
     */
    public function setProvincia(\AppBundle\Entity\Provincias $provincia = null)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return \AppBundle\Entity\Provincias
     */
    public function getProvincia()
    {
        return $this->provincia;
    }
    public function __toString(){
        return $this->nombre;
    }
}
