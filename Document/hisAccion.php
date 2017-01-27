<?php

namespace UCI\Boson\TrazasBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Class for document hisAccion
 * 
 * @author René Leandro Cruz Laguna <rlcruz@uci.cu>
 * 
 */

/**
 * @MongoDB\Document(collection="his_accion",repositoryClass="UCI\Boson\TrazasBundle\Repository\hisAccionMongoDBRepository")
 */
class hisAccion extends hisTraza {

    /**
     * @MongoDB\String
     */
    private $referencia;

    /**
     * @MongoDB\String
     */
    private $controlador;

    /**
     * @MongoDB\String
     */
    private $accion;

    /**
     * @MongoDB\Boolean
     */
    private $inicio;

    /**
     * @MongoDB\Boolean
     */
    private $falla;

    /** @MongoDB\EmbedOne(targetDocument="hisRendimiento",name="his_rendimiento") */
    private $rendimiento;

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
     * Set referencia
     *
     * @param string $referencia
     * 
     * @return self 
     */
    public function setReferencia($referencia)
    {
        $this->referencia = $referencia;
        return $this;
    }

    /**
     * Get referencia
     *
     * @return string $referencia
     */
    public function getReferencia()
    {
        return $this->referencia;
    }

    /**
     * Set controlador
     *
     * @param string $controlador
     * 
     * @return self
     */
    public function setControlador($controlador)
    {
        $this->controlador = $controlador;
        return $this;
    }

    /**
     * Get controlador
     *
     * @return string $controlador
     */
    public function getControlador()
    {
        return $this->controlador;
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
     * Set inicio
     *
     * @param boolean $inicio
     * 
     * @return self
     */
    public function setInicio($inicio)
    {
        $this->inicio = $inicio;
        return $this;
    }

    /**
     * Get inicio
     *
     * @return boolean $inicio
     */
    public function getInicio()
    {
        return $this->inicio;
    }

    /**
     * Set falla
     *
     * @param boolean $falla
     * 
     * @return self
     */
    public function setFalla($falla)
    {
        $this->falla = $falla;
        return $this;
    }

    /**
     * Get falla
     *
     * @return boolean $falla
     */
    public function getFalla()
    {
        return $this->falla;
    }

    /**
     * Set rendimiento
     *
     * @param UCI\Boson\TrazasBundle\Document\hisRendimiento $rendimiento
     * 
     * @return self
     */
    public function setRendimiento(\UCI\Boson\TrazasBundle\Document\hisRendimiento $rendimiento)
    {
        $this->rendimiento = $rendimiento;
        return $this;
    }

    /**
     * Get rendimiento
     *
     * @return UCI\Boson\TrazasBundle\Document\hisRendimiento $rendimiento
     */
    public function getRendimiento()
    {
        return $this->rendimiento;
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
