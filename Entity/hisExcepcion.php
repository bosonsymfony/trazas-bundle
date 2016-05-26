<?php

namespace UCI\Boson\TrazasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * hisExcepcion
 *
 * @ORM\Table(name="his_excepcion")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="UCI\Boson\TrazasBundle\Repository\hisExcepcionRepository")
 */
class hisExcepcion extends hisTraza {

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=255, nullable=false)
     */
    private $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="mensaje", type="string", length=1000, nullable=false)
     */
    private $mensaje;

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return hisExcepcion
     */
    public function setTipo($tipo) {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string 
     */
    public function getTipo() {
        return $this->tipo;
    }

    /**
     * Set mensaje
     *
     * @param string $mensaje
     * @return hisExcepcion
     */
    public function setMensaje($mensaje) {
        $this->mensaje = $mensaje;

        return $this;
    }

    /**
     * Get mensaje
     *
     * @return string 
     */
    public function getMensaje() {
        return $this->mensaje;
    }


}
