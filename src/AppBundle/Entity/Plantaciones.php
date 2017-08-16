<?php

namespace AppBundle\Entity;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Plantaciones
 *
 * @ORM\Table(name="plantaciones", indexes={@ORM\Index(name="index_plantaciones_on_tipo_plantacion_id", columns={"tipo_plantacion_id"}), @ORM\Index(name="index_plantaciones_on_provincia_id", columns={"provincia_id"}), @ORM\Index(name="index_plantaciones_on_estado_plantacion_id", columns={"estado_plantacion_id"}), @ORM\Index(name="index_plantaciones_on_titular_id", columns={"titular_id"}), @ORM\Index(name="index_plantaciones_on_departamento_id", columns={"departamento_id"}), @ORM\Index(name="index_plantaciones_on_uso_anterior_id", columns={"uso_anterior_id"}), @ORM\Index(name="index_plantaciones_on_estrato_desarrollo_id", columns={"estrato_desarrollo_id"}), @ORM\Index(name="index_plantaciones_on_objetivo_plantacion_id", columns={"objetivo_plantacion_id"}), @ORM\Index(name="index_plantaciones_on_activo", columns={"activo"}), @ORM\Index(name="index_plantaciones_on_uso_forestal_id", columns={"uso_forestal_id"}), @ORM\Index(name="index_plantaciones_on_base_geometrica_id", columns={"base_geometrica_id"}), @ORM\Index(name="index_plantaciones_on_fuente_informacion_id", columns={"fuente_informacion_id"}), @ORM\Index(name="index_plantaciones_on_geom", columns={"geom"}), @ORM\Index(name="index_plantaciones_on_error_id", columns={"error_id"}), @ORM\Index(name="index_plantaciones_on_fuente_imagen_id", columns={"fuente_imagen_id"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Plantaciones
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="plantaciones_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="anio_plantacion", type="string", length=255, nullable=true)
     */
    private $anioPlantacion;

    /**
     * @var string
     *
     * @ORM\Column(name="nomenclatura_catastral", type="string", length=255, nullable=true)
     */
    private $nomenclaturaCatastral;

    /**
     * @var string
     *
     * @ORM\Column(name="distancia_plantas", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $distanciaPlantas;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad_filas", type="integer", nullable=true)
     */
    private $cantidadFilas;

    /**
     * @var string
     *
     * @ORM\Column(name="distancia_filas", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $distanciaFilas;

    /**
     * @var string
     *
     * @ORM\Column(name="densidad", type="string", length=255, nullable=true)
     */
    private $densidad;

    /**
     * @var integer
     *
     * @ORM\Column(name="anio_informacion", type="integer", nullable=true)
     */
    private $anioInformacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_imagen", type="date", nullable=true)
     */
    private $fechaImagen;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean", nullable=true)
     */
    private $activo;

    /**
     * @var string
     *
     * @ORM\Column(name="comentarios", type="text", nullable=true)
     */
    private $comentarios;

    /**
     * @var integer
     *
     * @ORM\Column(name="mpf_id", type="integer", nullable=true)
     */
    private $mpfId;

    /**
     * @var integer
     *
     * @ORM\Column(name="unificado_id", type="integer", nullable=true)
     */
    private $unificadoId;

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
     * @var geometry
     *
     * @ORM\Column(name="geom", type="geometry", nullable=true)
     */
    private $geom;

    /**
     * @var \BasesGeometricas
     *
     * @ORM\ManyToOne(targetEntity="BasesGeometricas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="base_geometrica_id", referencedColumnName="id")
     * })
     */
    private $baseGeometricaId;

    /**
     * @var \Errores
     *
     * @ORM\ManyToOne(targetEntity="Errores")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="error_id", referencedColumnName="id")
     * })
     */
    private $error;

    /**
     * @var \EstadosPlantacion
     *
     * @ORM\ManyToOne(targetEntity="EstadosPlantacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="estado_plantacion_id", referencedColumnName="id")
     * })
     */
    private $estadoPlantacion;

    /**
     * @var \EstratosDesarrollo
     *
     * @ORM\ManyToOne(targetEntity="EstratosDesarrollo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="estrato_desarrollo_id", referencedColumnName="id")
     * })
     */
    private $estratoDesarrollo;

    /**
     * @var \FuentesImagen
     *
     * @ORM\ManyToOne(targetEntity="FuentesImagen")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fuente_imagen_id", referencedColumnName="id")
     * })
     */
    private $fuenteImagen;

    /**
     * @var \FuentesInformacion
     *
     * @ORM\ManyToOne(targetEntity="FuentesInformacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fuente_informacion_id", referencedColumnName="id")
     * })
     */
    private $fuenteInformacion;

    /**
     * @var \ObjetivosPlantacion
     *
     * @ORM\ManyToOne(targetEntity="ObjetivosPlantacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="objetivo_plantacion_id", referencedColumnName="id")
     * })
     */
    private $objetivoPlantacion;

    /**
     * @var \TiposPlantacion
     *
     * @ORM\ManyToOne(targetEntity="TiposPlantacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_plantacion_id", referencedColumnName="id")
     * })
     */
    private $tipoPlantacion;

    /**
     * @var \Titulares
     *
     * @ORM\ManyToOne(targetEntity="Titulares")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="titular_id", referencedColumnName="id")
     * })
     */
    private $titular;

    /**
     * @var \UsosAnteriores
     *
     * @ORM\ManyToOne(targetEntity="UsosAnteriores")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="uso_anterior_id", referencedColumnName="id")
     * })
     */
    private $usoAnterior;

    /**
     * @var \UsosForestales
     *
     * @ORM\ManyToOne(targetEntity="UsosForestales")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="uso_forestal_id", referencedColumnName="id")
     * })
     */
    private $usoForestal;

    /**
     * @var \Provincias
     *
     * @ORM\ManyToOne(targetEntity="Provincias", fetch="LAZY")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="provincia_id", referencedColumnName="id")
     * })
     */
    private $provincia;

    /**
     * @var \Departamentos
     *
     * @ORM\ManyToOne(targetEntity="Departamentos", fetch="LAZY")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="departamento_id", referencedColumnName="id")
     * })
     */
    private $departamento;

    /**
      * @var \Especies
      * @ORM\ManyToMany(targetEntity="Especies", fetch="LAZY")
      * @ORM\JoinTable(
      *      name="especies_plantaciones",
      *      joinColumns={@ORM\JoinColumn(name="plantacion_id", referencedColumnName="id")},
      *      inverseJoinColumns={@ORM\JoinColumn(name="especie_id", referencedColumnName="id")}
      * )
      */
     private $especie;

    /**
    * @var \Doctrine\Common\Collections\ArrayCollection|Actividades[]
    * @ORM\OneToMany(targetEntity="ActividadesPlantaciones",mappedBy="plantacion",cascade={"persist"}, fetch="LAZY")
    */
     private $actividad;

     /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\OneToMany(targetEntity="PlantacionesHistorico", mappedBy="plantacionAnterior", cascade={"persist","remove"}, fetch="LAZY")
     */
     private $historico;

     /**
      * Set Historico
      *
      * @param \AppBundle\Entity\PlantacionesHistorico $historico
      *
      * @return PlantacionesHistorico
      */
     public function setHistorico($historico = null)
     {
         $this->historico[] = $historico;

         return $this;
     }

     /**
     * @param Titulares $titular
     */
    public function addHistorico($historico)
    {
      if (true === $this->historico->contains($historico->getPlantacionNueva()->getId())) {
        return;
      }
      $this->historico[]=$historico;
    }
     /**
      * Get Historico
      *
      * @return \AppBundle\Entity\PlantacionesHistorico
      */
     public function getHistorico()
     {
         return $this->historico;
     }

     public function removeHistorico($historico)
     {
       if (true === $this->historico->contains($historico)) {
           return;
       }
       $this->historico->removeElement($historico);
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

     public function setActividad(\AppBundle\Entity\Actividades $actividad){
       if (true === $this->actividad->contains($actividad)) {
           return;
       }
       $this->actividad->add($actividad);
       $actividad->setActividad($this);
       return $this;
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
     * Set anioPlantacion
     *
     * @param string $anioPlantacion
     *
     * @return Plantaciones
     */
    public function setAnioPlantacion($anioPlantacion)
    {
        $this->anioPlantacion = $anioPlantacion;

        return $this;
    }

    /**
     * Get anioPlantacion
     *
     * @return string
     */
    public function getAnioPlantacion()
    {
        return $this->anioPlantacion;
    }

    /**
     * Set nomenclaturaCatastral
     *
     * @param string $nomenclaturaCatastral
     *
     * @return Plantaciones
     */
    public function setNomenclaturaCatastral($nomenclaturaCatastral)
    {
        $this->nomenclaturaCatastral = $nomenclaturaCatastral;

        return $this;
    }

    /**
     * Get nomenclaturaCatastral
     *
     * @return string
     */
    public function getNomenclaturaCatastral()
    {
        return $this->nomenclaturaCatastral;
    }

    /**
     * Set distanciaPlantas
     *
     * @param string $distanciaPlantas
     *
     * @return Plantaciones
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
     * Set cantidadFilas
     *
     * @param integer $cantidadFilas
     *
     * @return Plantaciones
     */
    public function setCantidadFilas($cantidadFilas)
    {
        $this->cantidadFilas = $cantidadFilas;

        return $this;
    }

    /**
     * Get cantidadFilas
     *
     * @return integer
     */
    public function getCantidadFilas()
    {
        return $this->cantidadFilas;
    }

    /**
     * Set distanciaFilas
     *
     * @param string $distanciaFilas
     *
     * @return Plantaciones
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
     * Set densidad
     *
     * @param string $densidad
     *
     * @return Plantaciones
     */
    public function setDensidad($densidad)
    {
        $this->densidad = $densidad;

        return $this;
    }

    /**
     * Get densidad
     *
     * @return string
     */
    public function getDensidad()
    {
        return $this->densidad;
    }

    /**
     * Set anioInformacion
     *
     * @param integer $anioInformacion
     *
     * @return Plantaciones
     */
    public function setAnioInformacion($anioInformacion)
    {
        $this->anioInformacion = $anioInformacion;

        return $this;
    }

    /**
     * Get anioInformacion
     *
     * @return integer
     */
    public function getAnioInformacion()
    {
        return $this->anioInformacion;
    }

    /**
     * Set fechaImagen
     *
     * @param \DateTime $fechaImagen
     *
     * @return Plantaciones
     */
    public function setFechaImagen($fechaImagen)
    {
        $this->fechaImagen = $fechaImagen;

        return $this;
    }

    /**
     * Get fechaImagen
     *
     * @return \DateTime
     */
    public function getFechaImagen()
    {
        return $this->fechaImagen;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Plantaciones
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
     * Set comentarios
     *
     * @param string $comentarios
     *
     * @return Plantaciones
     */
    public function setComentarios($comentarios)
    {
        $this->comentarios = $comentarios;

        return $this;
    }

    /**
     * Get comentarios
     *
     * @return string
     */
    public function getComentarios()
    {
        return $this->comentarios;
    }

    /**
     * Set mpfId
     *
     * @param integer $mpfId
     *
     * @return Plantaciones
     */
    public function setMpfId($mpfId)
    {
        $this->mpfId = $mpfId;

        return $this;
    }

    /**
     * Get mpfId
     *
     * @return integer
     */
    public function getMpfId()
    {
        return $this->mpfId;
    }

    /**
     * Set unificadoId
     *
     * @param integer $unificadoId
     *
     * @return Plantaciones
     */
    public function setUnificadoId($unificadoId)
    {
        $this->unificadoId = $unificadoId;

        return $this;
    }

    /**
     * Get unificadoId
     *
     * @return integer
     */
    public function getUnificadoId()
    {
        return $this->unificadoId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Plantaciones
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
     * @return Plantaciones
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
     * Set geom
     *
     * @param geometry $geom
     *
     * @return Plantaciones
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
     * Set baseGeometricaId
     *
     * @param integer $baseGeometricaId
     *
     * @return Plantaciones
     */
    public function setBaseGeometricaId($baseGeometricaId)
    {
        $this->baseGeometricaId = $baseGeometricaId;

        return $this;
    }

    /**
     * Get baseGeometricaId
     *
     * @return integer
     */
    public function getBaseGeometricaId()
    {
        return $this->baseGeometricaId;
    }

    /**
     * Set error
     *
     * @param \AppBundle\Entity\Errores $error
     *
     * @return Plantaciones
     */
    public function setError(\AppBundle\Entity\Errores $error = null)
    {
        $this->error = $error;

        return $this;
    }

    /**
     * Get error
     *
     * @return \AppBundle\Entity\Errores
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Set estadoPlantacion
     *
     * @param \AppBundle\Entity\EstadosPlantacion $estadoPlantacion
     *
     * @return Plantaciones
     */
    public function setEstadoPlantacion(\AppBundle\Entity\EstadosPlantacion $estadoPlantacion = null)
    {
        $this->estadoPlantacion = $estadoPlantacion;

        return $this;
    }

    /**
     * Get estadoPlantacion
     *
     * @return \AppBundle\Entity\EstadosPlantacion
     */
    public function getEstadoPlantacion()
    {
        return $this->estadoPlantacion;
    }

    /**
     * Set estratoDesarrollo
     *
     * @param \AppBundle\Entity\EstratosDesarrollo $estratoDesarrollo
     *
     * @return Plantaciones
     */
    public function setEstratoDesarrollo(\AppBundle\Entity\EstratosDesarrollo $estratoDesarrollo = null)
    {
        $this->estratoDesarrollo = $estratoDesarrollo;

        return $this;
    }

    /**
     * Get estratoDesarrollo
     *
     * @return \AppBundle\Entity\EstratosDesarrollo
     */
    public function getEstratoDesarrollo()
    {
        return $this->estratoDesarrollo;
    }

    /**
     * Set fuenteImagen
     *
     * @param \AppBundle\Entity\FuentesImagen $fuenteImagen
     *
     * @return Plantaciones
     */
    public function setFuenteImagen(\AppBundle\Entity\FuentesImagen $fuenteImagen = null)
    {
        $this->fuenteImagen = $fuenteImagen;

        return $this;
    }

    /**
     * Get fuenteImagen
     *
     * @return \AppBundle\Entity\FuentesImagen
     */
    public function getFuenteImagen()
    {
        return $this->fuenteImagen;
    }

    /**
     * Set fuenteInformacion
     *
     * @param \AppBundle\Entity\FuentesInformacion $fuenteInformacion
     *
     * @return Plantaciones
     */
    public function setFuenteInformacion(\AppBundle\Entity\FuentesInformacion $fuenteInformacion = null)
    {
        $this->fuenteInformacion = $fuenteInformacion;

        return $this;
    }

    /**
     * Get fuenteInformacion
     *
     * @return \AppBundle\Entity\FuentesInformacion
     */
    public function getFuenteInformacion()
    {
        return $this->fuenteInformacion;
    }

    /**
     * Set objetivoPlantacion
     *
     * @param \AppBundle\Entity\ObjetivosPlantacion $objetivoPlantacion
     *
     * @return Plantaciones
     */
    public function setObjetivoPlantacion(\AppBundle\Entity\ObjetivosPlantacion $objetivoPlantacion = null)
    {
        $this->objetivoPlantacion = $objetivoPlantacion;

        return $this;
    }

    /**
     * Get objetivoPlantacion
     *
     * @return \AppBundle\Entity\ObjetivosPlantacion
     */
    public function getObjetivoPlantacion()
    {
        return $this->objetivoPlantacion;
    }

    /**
     * Set tipoPlantacion
     *
     * @param \AppBundle\Entity\TiposPlantacion $tipoPlantacion
     *
     * @return Plantaciones
     */
    public function setTipoPlantacion(\AppBundle\Entity\TiposPlantacion $tipoPlantacion = null)
    {
        $this->tipoPlantacion = $tipoPlantacion;

        return $this;
    }

    /**
     * Get tipoPlantacion
     *
     * @return \AppBundle\Entity\TiposPlantacion
     */
    public function getTipoPlantacion()
    {
        return $this->tipoPlantacion;
    }

    /**
     * Set titular
     *
     * @param \AppBundle\Entity\Titulares $titular
     *
     * @return Plantaciones
     */
    public function setTitular(\AppBundle\Entity\Titulares $titular = null)
    {
        $this->titular = $titular;

        return $this;
    }

    /**
     * Get titular
     *
     * @return \AppBundle\Entity\Titulares
     */
    public function getTitular()
    {
        return $this->titular;
    }

    /**
     * Set usoAnterior
     *
     * @param \AppBundle\Entity\UsosAnteriores $usoAnterior
     *
     * @return Plantaciones
     */
    public function setUsoAnterior(\AppBundle\Entity\UsosAnteriores $usoAnterior = null)
    {
        $this->usoAnterior = $usoAnterior;

        return $this;
    }

    /**
     * Get usoAnterior
     *
     * @return \AppBundle\Entity\UsosAnteriores
     */
    public function getUsoAnterior()
    {
        return $this->usoAnterior;
    }

    /**
     * Set usoForestal
     *
     * @param \AppBundle\Entity\UsosForestales $usoForestal
     *
     * @return Plantaciones
     */
    public function setUsoForestal(\AppBundle\Entity\UsosForestales $usoForestal = null)
    {
        $this->usoForestal = $usoForestal;

        return $this;
    }

    /**
     * Get usoForestal
     *
     * @return \AppBundle\Entity\UsosForestales
     */
    public function getUsoForestal()
    {
        return $this->usoForestal;
    }

    /**
     * Set provincia
     *
     * @param \AppBundle\Entity\Provincias $provincia
     *
     * @return Plantaciones
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

    /**
     * Set departamento
     *
     * @param \AppBundle\Entity\Departamentos $departamento
     *
     * @return Plantaciones
     */
    public function setDepartamento(\AppBundle\Entity\Departamentos $departamento = null)
    {
        $this->departamento = $departamento;

        return $this;
    }

    /**
     * Get departamento
     *
     * @return \AppBundle\Entity\Departamentos
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }
    /**
     * Get especie
     *
     * @return \AppBundle\Entity\Especies
     */
    public function getEspecie(){
        return $this->especie;
    }

    /**
    * @param Especie $titular
    */
     public function setEspecie($especie)
     {
       if (true === $this->especie->contains($especie)) {
         return;
       }
       $this->especie=$especie;
     }

     /**
     * @param Especie $titular
     */
      public function addEspecie($especie)
      {
        if (true === $this->especie->contains($especie)) {
          return;
        }
        $this->especie[]=$especie;
      }

      /**
      * @param Especie $titular
      */
       public function removeEspecie($especie)
       {
         if (true === $this->especie->contains($especie)) {
             return;
         }
         $this->especie->removeElement($especie);
       }
    /**
     * Get actividades
     *
     * @return \AppBundle\Entity\Actividades
     */
    public function getActividad()
    {
        return $this->actividad;
    }

    public function __construct() {
        $this->especie = new \Doctrine\Common\Collections\ArrayCollection();
        $this->actividad = new \Doctrine\Common\Collections\ArrayCollection();
        $this->historico = new \Doctrine\Common\Collections\ArrayCollection();
    }
    public function __toString() {
      return (string)$this->id;
  }

}
