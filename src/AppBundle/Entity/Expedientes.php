<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use AppBundle\Entity\Expedientes;
use Doctrine\ORM\Mapping\ManyToMany;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Expedientes
 *
 * @ORM\Table(name="expedientes", indexes={@ORM\Index(name="index_expedientes_on_tecnico_id", columns={"tecnico_id"}), @ORM\Index(name="index_expedientes_on_zona_departamento_id", columns={"zona_departamento_id"}), @ORM\Index(name="index_expedientes_on_zona_id", columns={"zona_id"}), @ORM\Index(name="index_expedientes_on_numero_expediente", columns={"numero_expediente"}), @ORM\Index(name="index_expedientes_on_numero_interno", columns={"numero_interno"})})
 * @ORM\Entity
 * @UniqueEntity(fields="numeroInterno",message="Este valor ya existe y no puede repetirse")
 * @UniqueEntity(fields="numeroExpediente",message="Este valor ya existe y no puede repetirse")
 * @ORM\HasLifecycleCallbacks
 */
class Expedientes
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="expedientes_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_interno", type="string", length=255, nullable=true)
     * @Assert\Regex(
     *     pattern     = "/[0-9]{2}-[0-9]{3}-[0-9]{3}\/[0-9]{2}/",
     *     message = "El formato debe ser ##-###-###/##"
     * )
     * @Assert\Length(min = 13, max=13, exactMessage="El campo debe tener {{ limit }} digitos, ##-###-###/##")
     * @Assert\NotBlank(message="El campo no puede estar vacío")
     */
    private $numeroInterno;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_expediente", type="string", length=255, nullable=true)
     * @Assert\Regex(
     *     pattern     = "/EXP-S05:[0-9]{7}\/[0-9]{4}|EX-20[0-9]{2}\-[0-9]{8}/",
     *     message     = "El formato debe ser EXP-S05:#######/#### o EX-20##-########"
     * )
     * @Assert\Length(min = 16, max=20, exactMessage="El campo debe tener {{ limit }} digitos, EXP-S05:#######/####")
     * @Assert\NotBlank(message="El campo no puede estar vacío")
     */
    private $numeroExpediente;

    /**
     * @var boolean
     *
     * @ORM\Column(name="agrupado", type="boolean", nullable=true)
     */
    private $agrupado;

    /**
     * @var boolean
     *
     * @ORM\Column(name="plurianual", type="boolean", nullable=true)
     */
    private $plurianual;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean", nullable=true)
     */
    private $activo;

    /**
     * @var integer
     *
     * @ORM\Column(name="anio", type="integer", nullable=true)
     */
    private $anio;

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
     * @var \ZonaDepartamentos
     *
     * @ORM\ManyToOne(targetEntity="ZonaDepartamentos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="zona_departamento_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $zonaDepartamento;

    /**
     * @var \Tecnicos
     *
     * @ORM\ManyToOne(targetEntity="Tecnicos", fetch="LAZY")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tecnico_id", referencedColumnName="id")
     * })
     */
    private $tecnico;

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
        * @var ArrayCollection $titulares
        * @ORM\ManyToMany(targetEntity="Titulares", inversedBy="expediente" ,cascade={"all","remove","persist"}, fetch="LAZY")
        * @ORM\JoinTable(
        *      name="expedientes_titulares",
        *      joinColumns={@ORM\JoinColumn(name="expediente_id", referencedColumnName="id",onDelete="CASCADE")},
        *      inverseJoinColumns={@ORM\JoinColumn(name="titular_id", referencedColumnName="id")}
        * )
        */
     private $titulares;

     /**
      * @var \Movimiento
      *
      * @ORM\OneToMany(targetEntity="Movimientos",mappedBy="expediente",orphanRemoval=true)
      */
     private $movimientos;
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
     * Set numeroInterno
     *
     * @param string $numeroInterno
     *
     * @return Expedientes
     */
    public function setNumeroInterno($numeroInterno)
    {
        $this->numeroInterno = $numeroInterno;

        return $this;
    }

    /**
     * Get numeroInterno
     *
     * @return string
     */
    public function getNumeroInterno()
    {
        return $this->numeroInterno;
    }

    /**
     * Set numeroExpediente
     *
     * @param string $numeroExpediente
     *
     * @return Expedientes
     */
    public function setNumeroExpediente($numeroExpediente)
    {
        $this->numeroExpediente = $numeroExpediente;

        return $this;
    }

    /**
     * Get numeroExpediente
     *
     * @return string
     */
    public function getNumeroExpediente()
    {
        return $this->numeroExpediente;
    }

    /**
     * Set agrupado
     *
     * @param boolean $agrupado
     *
     * @return Expedientes
     */
    public function setAgrupado($agrupado)
    {
        $this->agrupado = $agrupado;

        return $this;
    }

    /**
     * Get agrupado
     *
     * @return boolean
     */
    public function getAgrupado()
    {
        return $this->agrupado;
    }

    /**
     * Set plurianual
     *
     * @param boolean $plurianual
     *
     * @return Expedientes
     */
    public function setPlurianual($plurianual)
    {
        $this->plurianual = $plurianual;

        return $this;
    }

    /**
     * Get plurianual
     *
     * @return boolean
     */
    public function getPlurianual()
    {
        return $this->plurianual;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Expedientes
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set anio
     *
     * @param integer $anio
     *
     * @return Expedientes
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;

        return $this;
    }

    /**
     * Get anio
     *
     * @return integer
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Expedientes
     */
    public function setCreatedAt($createdAt)
    {
      if(!$this->createdAt){
          $this->createdAt = new \DateTime();
      }
      //$this->createdAt = $createdAt;

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
     * @return Expedientes
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = new \DateTime();
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
     * Set zonaDepartamento
     *
     * @param integer $zonaDepartamento
     *
     * @return integer
     */
    public function setZonaDepartamento($zonaDepartamento = null)
    {
        $this->zonaDepartamento = $zonaDepartamento;

        return $this;
    }

    /**
     * Get zonaDepartamento
     *
     * @return \AppBundle\Entity\ZonaDepartamentos
     */
    public function getZonaDepartamento()
    {
        return $this->zonaDepartamento;
    }

    /**
     * Set tecnico
     *
     * @param \AppBundle\Entity\Tecnicos $tecnico
     *
     * @return Expedientes
     */
    public function setTecnico(\AppBundle\Entity\Tecnicos $tecnico = null)
    {
        $this->tecnico = $tecnico;

        return $this;
    }

    /**
     * Get tecnico
     *
     * @return \AppBundle\Entity\Tecnicos
     */
    public function getTecnico()
    {
        return $this->tecnico;
    }



    /**
     * Set Movimiento
     *
     * @param \AppBundle\Entity\Movimientos $movimientos
     *
     * @return Expedientes
     */
    public function setMovimientos(\AppBundle\Entity\Movimientos $movimientos = null)
    {
        $this->movimientos = $movimientos;

        return $this;
    }

    /**
     * Get movimientos
     *
     * @return \AppBundle\Entity\Movimientos
     */
    public function getMovimientos()
    {
        return $this->movimientos;
    }
    /**
     * Set zona
     *
     * @param integer $zona
     *
     * @return integer
     */
    public function setZona($zona = null)
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
    /**
     * Set titular
     *
     * @param \AppBundle\Entity\Titulares $titular
     *
     * @return Titulares
     */
    public function setTitulares(array $titulares = null)
    {
        $this->titulares[] = $titulares;
        return $this->titulares;
    }

    public function getTitulares()
    {
        return array($this->titulares);
    }

    /**
    * @param Titulares $titular
    */
   public function addTitular($titular)
   {
       if (true === $this->titulares->contains($titular)) {
           return;
       }
       $this->titulares[] = $titular;

   }

   public function removeTitular($titular)
   {
       foreach ($titular as $key => $value) {
         $titu = $value;
         if (false === $this->titulares->contains($titu)) {
             return;
         }
         $this->titulares->removeElement($titu);
       }
   }

    /**
     * Get zonaSplit
     *
     * @return string
     */
    public function getZonaSplit()
    {
        return substr( $this->numeroInterno, 0, 2);
    }

    /**
     * Get zonaDeptoSplit
     *
     * @return string
     */
    public function getZonaDeptoSplit()
    {
        return substr( $this->numeroInterno, 3, 3);
    }

    /**
     * Get anioSplit
     *
     * @return integer
     */
    public function getAnioSplit()
    {
        $anio = (int)substr( $this->numeroInterno, 11, 2);
        if ($anio < 80){
          $anio = $anio + 2000;
        }else{
          $anio = $anio + 1900;
        }
        return $anio;
    }

    /**
     * Get titularesId
     *
     * @return integer
     */
    public function getTitularesId()
    {
        if ($this->titulares) {
            return $this->titulares->id;
        }

        return null;
    }

    public function getTitularesGroup(){
      if($this->titulares){
        $titularesGroup='';
        foreach ($this->titulares as $key => $value) {
          $titularesGroup = $titularesGroup . ' - ' . $value->getNombre();
        }
      }
      return $titularesGroup;
    }

    public function getResponsablesGroup(){
      if($this->movimientos){
        $responsablesGroup='';
        foreach ($this->movimientos as $key => $value) {
          $responsablesGroup = $responsablesGroup . ' - ' . $value->getResponsable();
        }
      }
      return $responsablesGroup;
    }

    public function __construct() {
        $this->tecnico = new \Doctrine\Common\Collections\ArrayCollection();
        $this->titulares = new \Doctrine\Common\Collections\ArrayCollection();
        $this->zonaDepartamento = new \Doctrine\Common\Collections\ArrayCollection();
        $this->movimientos = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
