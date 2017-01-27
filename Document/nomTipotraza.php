<?php

namespace UCI\Boson\TrazasBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Class for document nomTipotraza
 * 
 * @author René Leandro Cruz Laguna <rlcruz@uci.cu>
 */

/**
 * @MongoDB\Document(collection="nom_tipotraza",repositoryClass="UCI\Boson\TrazasBundle\Repository\nomTipoTrazaMongoDBRepository")
 */
class nomTipotraza {

    /**
     * @MongoDB\Id()
     */
    private $idTipotraza;

    /**
     * @MongoDB\String
     * @MongoDB\Index(unique=true, order="asc")
     */
    private $tipotraza;

    /**
     * @MongoDB\ReferenceMany(targetDocument="hisTraza", mappedBy="tipotraza",cascade={"remove"})
     */
    private $trazas;

    /**
     * Get idTipotraza
     *
     * @return id $idTipotraza
     */
    public function getIdTipotraza() {
        return $this->idTipotraza;
    }

    /**
     * Set tipotraza
     *
     * @param string $tipotraza
     * 
     * @return self
     */
    public function setTipotraza($tipotraza) {
        $this->tipotraza = $tipotraza;
        return $this;
    }

    /**
     * Get tipotraza
     *
     * @return string $tipotraza
     */
    public function getTipotraza() {
        return $this->tipotraza;
    }

    /**
     * Construct
     */
    public function __construct() {
        $this->trazas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add traza
     *
     * @param UCI\Boson\TrazasBundle\Document\hisTraza $traza
     */
    public function addTraza(\UCI\Boson\TrazasBundle\Document\hisTraza $traza) {
        $this->trazas[] = $traza;
    }

    /**
     * Remove traza
     *
     * @param UCI\Boson\TrazasBundle\Document\hisTraza $traza
     */
    public function removeTraza(\UCI\Boson\TrazasBundle\Document\hisTraza $traza) {
        $this->trazas->removeElement($traza);
    }

    /**
     * Get trazas
     *
     * @return Doctrine\Common\Collections\Collection $trazas
     */
    public function getTrazas() {
        return $this->trazas;
    }

}
