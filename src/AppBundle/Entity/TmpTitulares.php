<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TmpTitulares
 *
 * @ORM\Table(name="tmp_titulares", indexes={@ORM\Index(name="index_tmp_titulares_on_titular_mayusculas", columns={"titular_mayusculas"}), @ORM\Index(name="index_tmp_titulares_on_cuit", columns={"cuit"}), @ORM\Index(name="index_tmp_titulares_on_titular", columns={"titular"}), @ORM\Index(name="index_tmp_titulares_on_numero_interno", columns={"numero_interno"}), @ORM\Index(name="index_tmp_titulares_on_dni", columns={"dni"})})
 * @ORM\Entity
 */
class TmpTitulares
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="tmp_titulares_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_interno", type="string", length=255, nullable=true)
     */
    private $numeroInterno;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_productor", type="string", length=255, nullable=true)
     */
    private $numeroProductor;

    /**
     * @var string
     *
     * @ORM\Column(name="titular", type="string", length=255, nullable=true)
     */
    private $titular;

    /**
     * @var string
     *
     * @ORM\Column(name="dni", type="string", length=255, nullable=true)
     */
    private $dni;

    /**
     * @var string
     *
     * @ORM\Column(name="cuit", type="string", length=255, nullable=true)
     */
    private $cuit;

    /**
     * @var string
     *
     * @ORM\Column(name="fuente", type="string", length=255, nullable=true)
     */
    private $fuente;

    /**
     * @var string
     *
     * @ORM\Column(name="titular_mayusculas", type="string", length=255, nullable=true)
     */
    private $titularMayusculas;



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
     * Set numeroInterno
     *
     * @param string $numeroInterno
     *
     * @return TmpTitulares
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
     * Set numeroProductor
     *
     * @param string $numeroProductor
     *
     * @return TmpTitulares
     */
    public function setNumeroProductor($numeroProductor)
    {
        $this->numeroProductor = $numeroProductor;

        return $this;
    }

    /**
     * Get numeroProductor
     *
     * @return string
     */
    public function getNumeroProductor()
    {
        return $this->numeroProductor;
    }

    /**
     * Set titular
     *
     * @param string $titular
     *
     * @return TmpTitulares
     */
    public function setTitular($titular)
    {
        $this->titular = $titular;

        return $this;
    }

    /**
     * Get titular
     *
     * @return string
     */
    public function getTitular()
    {
        return $this->titular;
    }

    /**
     * Set dni
     *
     * @param string $dni
     *
     * @return TmpTitulares
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
     * @return TmpTitulares
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
     * Set fuente
     *
     * @param string $fuente
     *
     * @return TmpTitulares
     */
    public function setFuente($fuente)
    {
        $this->fuente = $fuente;

        return $this;
    }

    /**
     * Get fuente
     *
     * @return string
     */
    public function getFuente()
    {
        return $this->fuente;
    }

    /**
     * Set titularMayusculas
     *
     * @param string $titularMayusculas
     *
     * @return TmpTitulares
     */
    public function setTitularMayusculas($titularMayusculas)
    {
        $this->titularMayusculas = $titularMayusculas;

        return $this;
    }

    /**
     * Get titularMayusculas
     *
     * @return string
     */
    public function getTitularMayusculas()
    {
        return $this->titularMayusculas;
    }
}
