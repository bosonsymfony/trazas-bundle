<?php

namespace UCI\Boson\TrazasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * nomTipotraza
 *
 * @ORM\Table(name="nom_tipotraza")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="UCI\Boson\TrazasBundle\Repository\nomTipoTrazaRepository")
 */
class nomTipotraza
{
    /**
     * @var float
     *
     * @ORM\Column(name="id_tipotraza", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\SequenceGenerator(sequenceName="sec_tipotraza_seq", allocationSize=1, initialValue=1)
     */
    private $idTipotraza;

    /**
     * @var string
     *
     * @ORM\Column(name="tipotraza", type="string", length=255, nullable=false)
     */
    private $tipotraza;



    /**
     * Get idTipotraza
     *
     * @return float 
     */
    public function getIdTipotraza()
    {
        return $this->idTipotraza;
    }

    /**
     * Set tipotraza
     *
     * @param string $tipotraza
     * @return nomTipotraza
     */
    public function setTipotraza($tipotraza)
    {
        $this->tipotraza = $tipotraza;
    
        return $this;
    }

    /**
     * Get tipotraza
     *
     * @return string 
     */
    public function getTipotraza()
    {
        return $this->tipotraza;
    }

    /**
     * @var \UCI\Boson\TrazasBundle\Entity\hisTraza
     *
     * @ORM\OneToMany(targetEntity="UCI\Boson\TrazasBundle\Entity\hisTraza", mappedBy="idTipotraza")
     * @ORM\JoinColumn(name="id_tipotraza", referencedColumnName="id_tipotraza")
     */
    private $trazas;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->trazas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add traza
     *
     * @param \UCI\Boson\TrazasBundle\Entity\hisTraza $traza
     *
     * @return nomTipotraza
     */
    public function addTraza(\UCI\Boson\TrazasBundle\Entity\hisTraza $traza)
    {
        $this->trazas[] = $traza;

        return $this;
    }

    /**
     * Remove traza
     *
     * @param \UCI\Boson\TrazasBundle\Entity\hisTraza $traza
     */
    public function removeTraza(\UCI\Boson\TrazasBundle\Entity\hisTraza $traza)
    {
        $this->trazas->removeElement($traza);
    }

    /**
     * Get trazas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTrazas()
    {
        return $this->trazas;
    }
}
