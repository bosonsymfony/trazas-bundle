<?php

namespace UCI\Boson\TrazasBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Class for document hisTraza
 * 
 * @author René Leandro Cruz Laguna <rlcruz@uci.cu>
 */

/**
 * @MongoDB\Document(collection="his_traza",repositoryClass="UCI\Boson\TrazasBundle\Repository\hisTrazaMongoDBRepository")
 * @MongoDB\InheritanceType("SINGLE_COLLECTION")
 * @MongoDB\DiscriminatorField("type")
 * @MongoDB\DiscriminatorMap({"accion"="hisAccion", "dato"="hisDato","excepcion"="hisExcepcion"})
 */
class hisTraza {

    /**
     * @MongoDB\Id(name="id_traza")
     */
    protected $idTraza;

    /**
     * @MongoDB\String
     */
    protected $fecha;

    /**
     * @MongoDB\String
     */
    protected $hora;

    /**
     * @MongoDB\String
     */
    protected $usuario;

    /**
     * @MongoDB\String(name="ip_host")
     */
    protected $ipHost;

    /**
     * @MongoDB\String
     */
    protected $rol;

    /**
     * @MongoDB\ReferenceOne(targetDocument="nomTipotraza", inversedBy="trazas")
     */
    protected $tipotraza;

    /**
     * Get idTraza
     *
     * @return int_id $idTraza
     */
    public function getIdTraza() {
        return $this->idTraza;
    }

    /**
     * Set fecha
     *
     * @param string $fecha
     * 
     * @return self
     */
    public function setFecha($fecha) {
        $this->fecha = $fecha;
        return $this;
    }

    /**
     * Get fecha
     *
     * @return string $fecha
     */
    public function getFecha() {
        return $this->fecha;
    }

    /**
     * Set hora
     *
     * @param string $hora
     * 
     * @return self
     */
    public function setHora($hora) {
        $this->hora = $hora;
        return $this;
    }

    /**
     * Get hora
     *
     * @return string $hora
     */
    public function getHora() {
        return $this->hora;
    }

    /**
     * Set usuario
     *
     * @param string $usuario
     * 
     * @return self
     */
    public function setUsuario($usuario) {
        $this->usuario = $usuario;
        return $this;
    }

    /**
     * Get usuario
     *
     * @return string $usuario
     */
    public function getUsuario() {
        return $this->usuario;
    }

    /**
     * Set ipHost
     *
     * @param string $ipHost
     * 
     * @return self
     */
    public function setIpHost($ipHost) {
        $this->ipHost = $ipHost;
        return $this;
    }

    /**
     * Get ipHost
     *
     * @return string $ipHost
     */
    public function getIpHost() {
        return $this->ipHost;
    }

    /**
     * Set rol
     *
     * @param string $rol
     * 
     * @return self
     */
    public function setRol($rol) {
        $this->rol = $rol;
        return $this;
    }

    /**
     * Get rol
     *
     * @return string $rol
     */
    public function getRol() {
        return $this->rol;
    }


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
         $this->tipotraza->addTraza($this);
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
