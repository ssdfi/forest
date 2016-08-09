<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EspeciesPlantaciones
 *
 * @ORM\Table(name="especies_plantaciones", indexes={@ORM\Index(name="IDX_82818A0EE70ED95B", columns={"especie_id"}), @ORM\Index(name="IDX_82818A0EBB9C202C", columns={"plantacion_id"})})
 * @ORM\Entity
 */
class EspeciesPlantaciones
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="especies_plantaciones_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \Especies
     *
     * @ORM\ManyToOne(targetEntity="Especies")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="especie_id", referencedColumnName="id")
     * })
     */
    private $especie;

    /**
     * @var \Plantaciones
     *
     * @ORM\ManyToOne(targetEntity="Plantaciones")
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
     * Set especie
     *
     * @param \AppBundle\Entity\Especies $especie
     *
     * @return EspeciesPlantaciones
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

    /**
     * Set plantacion
     *
     * @param \AppBundle\Entity\Plantaciones $plantacion
     *
     * @return EspeciesPlantaciones
     */
    public function setPlantacion(\AppBundle\Entity\Plantaciones $plantacion = null)
    {
        $this->plantacion = $plantacion;

        return $this;
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
}
