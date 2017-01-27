<?php

namespace UCI\Boson\TrazasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * hisRendimiento
 *
 * @ORM\Table(name="his_rendimiento")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="UCI\Boson\TrazasBundle\Repository\hisRendimientoRepository")
 */
class hisRendimiento
{
    /**
     * @var float
     *
     * @ORM\Column(name="tiempo_ejecucion", type="float", nullable=false)
     */
    private $tiempoEjecucion;

    /**
     * @var float
     *
     * @ORM\Column(name="memoria", type="float", nullable=false)
     */
    private $memoria;

    /**
     * @var \hisAccion
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="UCI\Boson\TrazasBundle\Entity\hisAccion", inversedBy="rendimiento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_accion", referencedColumnName="id_traza", onDelete="CASCADE")
     * })
     */
    private $accion;



    /**
     * Set tiempoEjecucion
     *
     * @param float $tiempoEjecucion
     * @return hisRendimiento
     */
    public function setTiempoEjecucion($tiempoEjecucion)
    {
        $this->tiempoEjecucion = $tiempoEjecucion;

        return $this;
    }

    /**
     * Get tiempoEjecucion
     *
     * @return float
     */
    public function getTiempoEjecucion()
    {
        return $this->tiempoEjecucion;
    }

    /**
     * Set memoria
     *
     * @param float $memoria
     * @return hisRendimiento
     */
    public function setMemoria($memoria)
    {
        $this->memoria = $memoria;

        return $this;
    }

    /**
     * Get memoria
     *
     * @return float
     */
    public function getMemoria()
    {
        return $this->memoria;
    }



    /**
     * Set accion
     *
     * @param \UCI\Boson\TrazasBundle\Entity\hisAccion $accion
     *
     * @return hisRendimiento
     */
    public function setAccion(\UCI\Boson\TrazasBundle\Entity\hisAccion $accion)
    {
        $this->accion = $accion;

        return $this;
    }

    /**
     * Get accion
     *
     * @return \UCI\Boson\TrazasBundle\Entity\hisAccion
     */
    public function getAccion()
    {
        return $this->accion;
    }
}
