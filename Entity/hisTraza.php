<?php

namespace UCI\Boson\TrazasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * hisTraza
 *
 * @ORM\Table(name="his_traza")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="UCI\Boson\TrazasBundle\Repository\hisTrazaRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discriminante", type="string")
 * @ORM\DiscriminatorMap({"a" = "hisAccion", "d" = "hisDato", "e" = "hisExcepcion", "r" = "hisRendimiento","t"="hisTraza"})

 */
class hisTraza
{
    /**
     * @var float
     *
     * @ORM\Column(name="id_traza", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\SequenceGenerator(sequenceName="sec_idtraza_seq", allocationSize=1, initialValue=1)
     */
    protected $idTraza;

    /**
     * @var string
     *
     * @ORM\Column(name="fecha", type="string", length = 100, nullable=false)
     */
    protected $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="hora", type="string", length = 100, nullable=false)
     */
    protected $hora;

    /**
     * @var string
     *
     * @ORM\Column(name="usuario", type="string", length=255, nullable=false)
     */
    protected $usuario;

    /**
     * @var string
     *
     * @ORM\Column(name="ip_host", type="string", length=255, nullable=false)
     */
    protected $ipHost;

    /**
     * @var string
     *
     * @ORM\Column(name="rol", type="string", length=255, nullable=false)
     */
    protected $rol;


    /**
     * @var nomTipotraza
     *
     * @ORM\ManyToOne(targetEntity="nomTipotraza", inversedBy="trazas")
     * @ORM\JoinColumn(name="id_tipotraza", referencedColumnName="id_tipotraza")
     */
    protected $idTipotraza;



    /**
     * Get idTraza
     *
     * @return float 
     */
    public function getIdTraza()
    {
        return $this->idTraza;
    }

    /**
     * Set fecha
     *
     * @param string $fecha
     * @return hisTraza
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    
        return $this;
    }

    /**
     * Get fecha
     *
     * @return string 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set hora
     *
     * @param string $hora
     * @return hisTraza
     */
    public function setHora($hora)
    {
        $this->hora = $hora;
    
        return $this;
    }

    /**
     * Get hora
     *
     * @return string 
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Set usuario
     *
     * @param string $usuario
     * @return hisTraza
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    
        return $this;
    }

    /**
     * Get usuario
     *
     * @return string 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set ipHost
     *
     * @param string $ipHost
     * @return hisTraza
     */
    public function setIpHost($ipHost)
    {
        $this->ipHost = $ipHost;
    
        return $this;
    }

    /**
     * Get ipHost
     *
     * @return string 
     */
    public function getIpHost()
    {
        return $this->ipHost;
    }

    /**
     * Set rol
     *
     * @param string $rol
     * @return hisTraza
     */
    public function setRol($rol)
    {
        $this->rol = $rol;
    
        return $this;
    }

    /**
     * Get rol
     *
     * @return string 
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * Set idTipotraza
     *
     * @param \UCI\Boson\TrazasBundle\Entity\nomTipotraza $idTipotraza
     * @return hisTraza
     */
    public function setIdTipotraza(\UCI\Boson\TrazasBundle\Entity\nomTipotraza $idTipotraza = null)
    {
        $this->idTipotraza = $idTipotraza;
    
        return $this;
    }

    /**
     * Get idTipotraza
     *
     * @return \UCI\Boson\TrazasBundle\Entity\nomTipotraza
     */
    public function getIdTipotraza()
    {
        return $this->idTipotraza;
    }
}