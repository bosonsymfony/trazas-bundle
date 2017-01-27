<?php

namespace UCI\Boson\TrazasBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Class for document hisDato
 * 
 * @author René Leandro Cruz Laguna <rlcruz@uci.cu>
 * 
 */
/**
 * @MongoDB\Document(collection="his_dato",repositoryClass="UCI\Boson\TrazasBundle\Repository\hisDatoMongoDBRepository")
 */
class hisDato extends hisTraza {

    /**
     * @MongoDB\String
     */
    private $esquema;

    /**
     * @MongoDB\String
     */
    private $tabla;

    /**
     * @MongoDB\String
     */
    private $accion;

    /**
     * @var $idTraza
     */
    protected $idTraza;

    /**
     * @var string $fecha
     */
    protected $fecha;

    /**
     * @var string $hora
     */
    protected $hora;

    /**
     * @var string $usuario
     */
    protected $usuario;

    /**
     * @var string $ipHost
     */
    protected $ipHost;

    /**
     * @var string $rol
     */
    protected $rol;


    /**
     * Set esquema
     *
     * @param string $esquema
     * 
     * @return self
     */
    public function setEsquema($esquema)
    {
        $this->esquema = $esquema;
        return $this;
    }

    /**
     * Get esquema
     *
     * @return string $esquema
     */
    public function getEsquema()
    {
        return $this->esquema;
    }

    /**
     * Set tabla
     *
     * @param string $tabla
     * 
     * @return self
     */
    public function setTabla($tabla)
    {
        $this->tabla = $tabla;
        return $this;
    }

    /**
     * Get tabla
     *
     * @return string $tabla
     */
    public function getTabla()
    {
        return $this->tabla;
    }

    /**
     * Set accion
     *
     * @param string $accion
     * 
     * @return self
     */
    public function setAccion($accion)
    {
        $this->accion = $accion;
        return $this;
    }

    /**
     * Get accion
     *
     * @return string $accion
     */
    public function getAccion()
    {
        return $this->accion;
    }

    /**
     * Get idTraza
     *
     * @return int_id $idTraza
     */
    public function getIdTraza()
    {
        return $this->idTraza;
    }

    /**
     * Set fecha
     *
     * @param string $fecha
     * 
     * @return self
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
        return $this;
    }

    /**
     * Get fecha
     *
     * @return string $fecha
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set hora
     *
     * @param string $hora
     * 
     * @return self
     */
    public function setHora($hora)
    {
        $this->hora = $hora;
        return $this;
    }

    /**
     * Get hora
     *
     * @return string $hora
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Set usuario
     *
     * @param string $usuario
     * 
     * @return self
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
        return $this;
    }

    /**
     * Get usuario
     *
     * @return string $usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set ipHost
     *
     * @param string $ipHost
     * 
     * @return self
     */
    public function setIpHost($ipHost)
    {
        $this->ipHost = $ipHost;
        return $this;
    }

    /**
     * Get ipHost
     *
     * @return string $ipHost
     */
    public function getIpHost()
    {
        return $this->ipHost;
    }

    /**
     * Set rol
     *
     * @param string $rol
     * 
     * @return self
     */
    public function setRol($rol)
    {
        $this->rol = $rol;
        return $this;
    }

    /**
     * Get rol
     *
     * @return string $rol
     */
    public function getRol()
    {
        return $this->rol;
    }
    /**
     * @var UCI\Boson\TrazasBundle\Document\nomTipotraza
     */
    protected $tipotraza;


    /**
     * Set tipotraza
     *
     * @param UCI\Boson\TrazasBundle\Document\nomTipotraza $tipotraza
     * 
     * @return self
     */
    public function setTipotraza(\UCI\Boson\TrazasBundle\Document\nomTipotraza $tipotraza)
    {
        $this->tipotraza = $tipotraza;
        return $this;
    }

    /**
     * Get tipotraza
     *
     * @return UCI\Boson\TrazasBundle\Document\nomTipotraza $tipotraza
     */
    public function getTipotraza()
    {
        return $this->tipotraza;
    }
}
