<?php

namespace UCI\Boson\TrazasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * hisAccion
 *
 * @ORM\Table(name="his_accion")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="UCI\Boson\TrazasBundle\Repository\hisAccionRepository")
 */
class hisAccion extends hisTraza
{
    /**
     * @var string
     *
     * @ORM\Column(name="referencia", type="string", length=255, nullable=false)
     */
    private $referencia;

    /**
     * @var string
     *
     * @ORM\Column(name="controlador", type="string", length=255, nullable=false)
     */
    private $controlador;

    /**
     * @var string
     *
     * @ORM\Column(name="accion", type="string", length=255, nullable=false)
     */
    private $accion;

    /**
     * @var string
     *
     * @ORM\Column(name="inicio", type="string", length=255, nullable=false)
     */
    private $inicio;

    /**
     * @var string
     *
     * @ORM\Column(name="falla", type="string", length=255, nullable=false)
     */
    private $falla;


    /**
     * @ORM\OneToOne(targetEntity="UCI\Boson\TrazasBundle\Entity\hisRendimiento", mappedBy="accion")
     */
    private $rendimiento;

    /**
     * Set referencia
     *
     * @param string $referencia
     * @return hisAccion
     */
    public function setReferencia($referencia)
    {
        $this->referencia = $referencia;
    
        return $this;
    }

    /**
     * Get referencia
     *
     * @return string 
     */
    public function getReferencia()
    {
        return $this->referencia;
    }

    /**
     * Set controlador
     *
     * @param string $controlador
     * @return hisAccion
     */
    public function setControlador($controlador)
    {
        $this->controlador = $controlador;
    
        return $this;
    }

    /**
     * Get controlador
     *
     * @return string 
     */
    public function getControlador()
    {
        return $this->controlador;
    }

    /**
     * Set accion
     *
     * @param string $accion
     * @return hisAccion
     */
    public function setAccion($accion)
    {
        $this->accion = $accion;
    
        return $this;
    }

    /**
     * Get accion
     *
     * @return string 
     */
    public function getAccion()
    {
        return $this->accion;
    }

    /**
     * Set inicio
     *
     * @param string $inicio
     * @return hisAccion
     */
    public function setInicio($inicio)
    {
        $this->inicio = $inicio;
    
        return $this;
    }

    /**
     * Get inicio
     *
     * @return string 
     */
    public function getInicio()
    {
        return $this->inicio;
    }

    /**
     * Set falla
     *
     * @param string $falla
     * @return hisAccion
     */
    public function setFalla($falla)
    {
        $this->falla = $falla;
    
        return $this;
    }

    /**
     * Get falla
     *
     * @return string 
     */
    public function getFalla()
    {
        return $this->falla;
    }


    /**
     * Set rendimiento
     *
     * @param \UCI\Boson\TrazasBundle\Entity\hisRendimiento $rendimiento
     *
     * @return hisAccion
     */
    public function setRendimiento(\UCI\Boson\TrazasBundle\Entity\hisRendimiento $rendimiento = null)
    {
        $this->rendimiento = $rendimiento;

        return $this;
    }

    /**
     * Get rendimiento
     *
     * @return \UCI\Boson\TrazasBundle\Entity\hisRendimiento
     */
    public function getRendimiento()
    {
        return $this->rendimiento;
    }
}
