<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Expedientes;
use Doctrine\ORM\Mapping\ManyToMany;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Titulares
 *
 * @ORM\Table(name="titulares", indexes={@ORM\Index(name="index_titulares_on_dni", columns={"dni"}), @ORM\Index(name="index_titulares_on_cuit", columns={"cuit"}), @ORM\Index(name="index_titulares_on_nombre", columns={"nombre"})})
 * @ORM\Entity
 */
class Titulares
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="titulares_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="El campo no puede estar vacío")
     * @Assert\Length(min = 4)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="dni", type="string", length=255, nullable=true)
     * @Assert\Type(type="numeric", message="El valor debe que ser numérico")
     * @Assert\NotBlank(message="El campo no puede estar vacío")
     * @Assert\Length(min = 8, max=8 ,exactMessage="El DNI debe tener {{ limit }} dígitos.")
     */
    private $dni;

    /**
     * @var string
     *
     * @ORM\Column(name="cuit", type="string", length=255, nullable=true)
     * @Assert\Type(type="numeric", message="El valor debe que ser numérico")
     * @Assert\NotBlank(message="El campo no puede estar vacío")
     * @Assert\Length(min = 11, max=11 ,exactMessage="El CUIT debe tener {{ limit }} dígitos.")
     */
    private $cuit;

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
    * @var ArrayCollection $expedientes
    * @ORM\ManyToMany(targetEntity="Expedientes", cascade={"all"}, fetch="EAGER")
    * @ORM\JoinTable(
    *      name="expedientes_titulares",
    *      joinColumns={@ORM\JoinColumn(name="titular_id", referencedColumnName="id")},
    *      inverseJoinColumns={@ORM\JoinColumn(name="expediente_id", referencedColumnName="id")}
    * )
    */
    private $expediente;


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
     * @return Titulares
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
     * Set dni
     *
     * @param string $dni
     *
     * @return Titulares
     */
    public function setDni($dni)
    {
        $this->dni = $dni;

        return $this;
    }

    /**
     * Get dni
     *
     * @return string
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set cuit
     *
     * @param string $cuit
     *
     * @return Titulares
     */
    public function setCuit($cuit)
    {
        $this->cuit = $cuit;

        return $this;
    }

    /**
     * Get cuit
     *
     * @return string
     */
    public function getCuit()
    {
        return $this->cuit;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Titulares
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
     * @return Titulares
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
     * Get expedientes
     *
     * @return \Expedientes
     */
    public function getExpedientes(){
        return $this->expediente;
    }

    public function getExpediente(){
        return $this->expediente;
    }
    public function __construct() {
        $this->expediente = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
