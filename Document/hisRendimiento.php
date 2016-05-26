<?php

namespace UCI\Boson\TrazasBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Class for document hisRendimiento
 * 
 * @author René Leandro Cruz Laguna <rlcruz@uci.cu>
 */


/** @MongoDB\EmbeddedDocument */
class hisRendimiento {

    /**
     * @MongoDB\Float(name="tiempo_ejecucion")
     */
    private $tiempoEjecucion;

    /**
     * @MongoDB\Float
     */
    private $memoria;

    


    /**
     * Set tiempoEjecucion
     *
     * @param float $tiempoEjecucion
     * @return self
     */
    public function setTiempoEjecucion($tiempoEjecucion)
    {
        $this->tiempoEjecucion = $tiempoEjecucion;
        return $this;
    }

    /**
     * Get tiempoEjecucion
     *
     * @return float $tiempoEjecucion
     */
    public function getTiempoEjecucion()
    {
        return $this->tiempoEjecucion;
    }

    /**
     * Set memoria
     *
     * @param float $memoria
     * @return self
     */
    public function setMemoria($memoria)
    {
        $this->memoria = $memoria;
        return $this;
    }

    /**
     * Get memoria
     *
     * @return float $memoria
     */
    public function getMemoria()
    {
        return $this->memoria;
    }
}
