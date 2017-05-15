<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Validaciones
 *
 * @ORM\Table(name="validaciones", indexes={@ORM\Index(name="index_validaciones_on_sistematizacion_id", columns={"sistematizacion_id"}), @ORM\Index(name="index_validaciones_on_responsable_id", columns={"responsable_id"}), @ORM\Index(name="index_validaciones_on_especie_2_id", columns={"especie_2_id"}), @ORM\Index(name="index_validaciones_on_plantacion_id", columns={"plantacion_id"}), @ORM\Index(name="index_validaciones_on_especie_3_id", columns={"especie_3_id"}), @ORM\Index(name="index_validaciones_on_especie_1_id", columns={"especie_1_id"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Validaciones
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="validaciones_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="plantacion_id", type="integer", nullable=true)
     */
    private $plantacionId;

    /**
     * @var integer
     *
     * @ORM\Column(name="responsable_id", type="integer", nullable=true)
     */
    private $responsableId;

    /**
     * @var integer
     *
     * @ORM\Column(name="especie_1_id", type="integer", nullable=true)
     */
    private $especie1Id;

    /**
     * @var integer
     *
     * @ORM\Column(name="especie_2_id", type="integer", nullable=true)
     */
    private $especie2Id;

    /**
     * @var integer
     *
     * @ORM\Column(name="especie_3_id", type="integer", nullable=true)
     */
    private $especie3Id;

    /**
     * @var integer
     *
     * @ORM\Column(name="edad_estimada", type="integer", nullable=true)
     */
    private $edadEstimada;

    /**
     * @var string
     *
     * @ORM\Column(name="densidad_estimada", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $densidadEstimada;

    /**
     * @var integer
     *
     * @ORM\Column(name="dap_promedio", type="integer", nullable=true)
     */
    private $dapPromedio;

    /**
     * @var integer
     *
     * @ORM\Column(name="altura_media_dominante", type="integer", nullable=true)
     */
    private $alturaMediaDominante;

    /**
     * @var integer
     *
     * @ORM\Column(name="numero_poda", type="integer", nullable=true)
     */
    private $numeroPoda;

    /**
     * @var integer
     *
     * @ORM\Column(name="numero_raleo", type="integer", nullable=true)
     */
    private $numeroRaleo;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad_poda", type="integer", nullable=true)
     */
    private $cantidadPoda;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad_raleo", type="integer", nullable=true)
     */
    private $cantidadRaleo;

    /**
     * @var integer
     *
     * @ORM\Column(name="sistematizacion_id", type="integer", nullable=true)
     */
    private $sistematizacionId;

    /**
     * @var string
     *
     * @ORM\Column(name="distancia_filas", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $distanciaFilas;

    /**
     * @var string
     *
     * @ORM\Column(name="distancia_plantas", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $distanciaPlantas;

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
     * Set plantacionId
     *
     * @param integer $plantacionId
     *
     * @return Validaciones
     */
    public function setPlantacionId($plantacionId)
    {
        $this->plantacionId = $plantacionId;

        return $this;
    }

    /**
     * Get plantacionId
     *
     * @return integer
     */
    public function getPlantacionId()
    {
        return $this->plantacionId;
    }

    /**
     * Set responsableId
     *
     * @param integer $responsableId
     *
     * @return Validaciones
     */
    public function setResponsableId($responsableId)
    {
        $this->responsableId = $responsableId;

        return $this;
    }

    /**
     * Get responsableId
     *
     * @return integer
     */
    public function getResponsableId()
    {
        return $this->responsableId;
    }

    /**
     * Set especie1Id
     *
     * @param integer $especie1Id
     *
     * @return Validaciones
     */
    public function setEspecie1Id($especie1Id)
    {
        $this->especie1Id = $especie1Id;

        return $this;
    }

    /**
     * Get especie1Id
     *
     * @return integer
     */
    public function getEspecie1Id()
    {
        return $this->especie1Id;
    }

    /**
     * Set especie2Id
     *
     * @param integer $especie2Id
     *
     * @return Validaciones
     */
    public function setEspecie2Id($especie2Id)
    {
        $this->especie2Id = $especie2Id;

        return $this;
    }

    /**
     * Get especie2Id
     *
     * @return integer
     */
    public function getEspecie2Id()
    {
        return $this->especie2Id;
    }

    /**
     * Set especie3Id
     *
     * @param integer $especie3Id
     *
     * @return Validaciones
     */
    public function setEspecie3Id($especie3Id)
    {
        $this->especie3Id = $especie3Id;

        return $this;
    }

    /**
     * Get especie3Id
     *
     * @return integer
     */
    public function getEspecie3Id()
    {
        return $this->especie3Id;
    }

    /**
     * Set edadEstimada
     *
     * @param integer $edadEstimada
     *
     * @return Validaciones
     */
    public function setEdadEstimada($edadEstimada)
    {
        $this->edadEstimada = $edadEstimada;

        return $this;
    }

    /**
     * Get edadEstimada
     *
     * @return integer
     */
    public function getEdadEstimada()
    {
        return $this->edadEstimada;
    }

    /**
     * Set densidadEstimada
     *
     * @param string $densidadEstimada
     *
     * @return Validaciones
     */
    public function setDensidadEstimada($densidadEstimada)
    {
        $this->densidadEstimada = $densidadEstimada;

        return $this;
    }

    /**
     * Get densidadEstimada
     *
     * @return string
     */
    public function getDensidadEstimada()
    {
        return $this->densidadEstimada;
    }

    /**
     * Set dapPromedio
     *
     * @param integer $dapPromedio
     *
     * @return Validaciones
     */
    public function setDapPromedio($dapPromedio)
    {
        $this->dapPromedio = $dapPromedio;

        return $this;
    }

    /**
     * Get dapPromedio
     *
     * @return integer
     */
    public function getDapPromedio()
    {
        return $this->dapPromedio;
    }

    /**
     * Set alturaMediaDominante
     *
     * @param integer $alturaMediaDominante
     *
     * @return Validaciones
     */
    public function setAlturaMediaDominante($alturaMediaDominante)
    {
        $this->alturaMediaDominante = $alturaMediaDominante;

        return $this;
    }

    /**
     * Get alturaMediaDominante
     *
     * @return integer
     */
    public function getAlturaMediaDominante()
    {
        return $this->alturaMediaDominante;
    }

    /**
     * Set numeroPoda
     *
     * @param integer $numeroPoda
     *
     * @return Validaciones
     */
    public function setNumeroPoda($numeroPoda)
    {
        $this->numeroPoda = $numeroPoda;

        return $this;
    }

    /**
     * Get numeroPoda
     *
     * @return integer
     */
    public function getNumeroPoda()
    {
        return $this->numeroPoda;
    }

    /**
     * Set numeroRaleo
     *
     * @param integer $numeroRaleo
     *
     * @return Validaciones
     */
    public function setNumeroRaleo($numeroRaleo)
    {
        $this->numeroRaleo = $numeroRaleo;

        return $this;
    }

    /**
     * Get numeroRaleo
     *
     * @return integer
     */
    public function getNumeroRaleo()
    {
        return $this->numeroRaleo;
    }

    /**
     * Set cantidadPoda
     *
     * @param integer $cantidadPoda
     *
     * @return Validaciones
     */
    public function setCantidadPoda($cantidadPoda)
    {
        $this->cantidadPoda = $cantidadPoda;

        return $this;
    }

    /**
     * Get cantidadPoda
     *
     * @return integer
     */
    public function getCantidadPoda()
    {
        return $this->cantidadPoda;
    }

    /**
     * Set cantidadRaleo
     *
     * @param integer $cantidadRaleo
     *
     * @return Validaciones
     */
    public function setCantidadRaleo($cantidadRaleo)
    {
        $this->cantidadRaleo = $cantidadRaleo;

        return $this;
    }

    /**
     * Get cantidadRaleo
     *
     * @return integer
     */
    public function getCantidadRaleo()
    {
        return $this->cantidadRaleo;
    }

    /**
     * Set sistematizacionId
     *
     * @param integer $sistematizacionId
     *
     * @return Validaciones
     */
    public function setSistematizacionId($sistematizacionId)
    {
        $this->sistematizacionId = $sistematizacionId;

        return $this;
    }

    /**
     * Get sistematizacionId
     *
     * @return integer
     */
    public function getSistematizacionId()
    {
        return $this->sistematizacionId;
    }

    /**
     * Set distanciaFilas
     *
     * @param string $distanciaFilas
     *
     * @return Validaciones
     */
    public function setDistanciaFilas($distanciaFilas)
    {
        $this->distanciaFilas = $distanciaFilas;

        return $this;
    }

    /**
     * Get distanciaFilas
     *
     * @return string
     */
    public function getDistanciaFilas()
    {
        return $this->distanciaFilas;
    }

    /**
     * Set distanciaPlantas
     *
     * @param string $distanciaPlantas
     *
     * @return Validaciones
     */
    public function setDistanciaPlantas($distanciaPlantas)
    {
        $this->distanciaPlantas = $distanciaPlantas;

        return $this;
    }

    /**
     * Get distanciaPlantas
     *
     * @return string
     */
    public function getDistanciaPlantas()
    {
        return $this->distanciaPlantas;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Validaciones
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
     * @return Validaciones
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
}
