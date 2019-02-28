<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlantacionesHistorico
 *
 * @ORM\Table(name="plantaciones_historico", indexes={@ORM\Index(name="index_plantaciones_historico_on_plantacion_nueva_id", columns={"plantacion_nueva_id"}), @ORM\Index(name="index_plantaciones_historico_on_plantacion_anterior_id", columns={"plantacion_anterior_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlantacionesHistoricoRepository")
 */
class PlantacionesHistorico
{
    /**
     * @var \Plantaciones
     * @ORM\ManyToOne(targetEntity="Plantaciones", inversedBy="historico")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="plantacion_anterior_id", referencedColumnName="id")
     * })
     */
    private $plantacionAnterior;

    /**
     * @var \Plantaciones
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Plantaciones")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="plantacion_nueva_id", referencedColumnName="id")
     * })
     */
    private $plantacionNueva;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->plantacionAnterior;
    }

    /**
     * Set plantacionAnterior
     *
     * @param \AppBundle\Entity\Plantaciones $plantacionAnterior
     *
     * @return PlantacionesHistorico
     */
    public function setPlantacionAnterior(\AppBundle\Entity\Plantaciones $plantacionAnterior = null)
    {
        $this->plantacionAnterior = $plantacionAnterior;

        return $this;
    }

    /**
     * Get plantacionAnterior
     *
     * @return \AppBundle\Entity\Plantaciones
     */
    public function getPlantacionAnterior()
    {
        return $this->plantacionAnterior;
    }

    /**
     * Set plantacionNueva
     *
     * @param \AppBundle\Entity\Plantaciones $plantacionNueva
     *
     * @return PlantacionesHistorico
     */
    public function setPlantacionNueva(\AppBundle\Entity\Plantaciones $plantacionNueva = null)
    {
        $this->plantacionNueva = $plantacionNueva;

        return $this;
    }

    /**
     * Get plantacionNueva
     *
     * @return \AppBundle\Entity\Plantaciones
     */
    public function getPlantacionNueva()
    {
        return $this->plantacionNueva;
    }

    public function __construct($plantacionNueva, $plantacionAnterior) {
        $this->plantacionNueva = $plantacionNueva;
        $this->plantacionAnterior = $plantacionAnterior;
    }

    public function __toString(){
      return (string)$this->plantacionNueva->getId();
    }
}
