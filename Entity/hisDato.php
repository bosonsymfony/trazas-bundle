<?php

namespace UCI\Boson\TrazasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * hisDato
 *
 * @ORM\Table(name="his_dato")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="UCI\Boson\TrazasBundle\Repository\hisDatoRepository")
 */
class hisDato extends hisTraza
{
    /**
     * @var string
     *
     * @ORM\Column(name="esquema", type="string", length=255, nullable=false)
     */
    private $esquema;

    /**
     * @var string
     *
     * @ORM\Column(name="tabla", type="string", length=255, nullable=false)
     */
    private $tabla;

    /**
     * @var string
     *
     * @ORM\Column(name="accion", type="string", length=255, nullable=false)
     */
    private $accion;

   /**
     * Set esquema
     *
     * @param string $esquema
     * @return hisDato
     */
    public function setEsquema($esquema)
    {
        $this->esquema = $esquema;
    
        return $this;
    }

    /**
     * Get esquema
     *
     * @return string 
     */
    public function getEsquema()
    {
        return $this->esquema;
    }

    /**
     * Set tabla
     *
     * @param string $tabla
     * @return hisDato
     */
    public function setTabla($tabla)
    {
        $this->tabla = $tabla;
    
        return $this;
    }

    /**
     * Get tabla
     *
     * @return string 
     */
    public function getTabla()
    {
        return $this->tabla;
    }

    /**
     * Set accion
     *
     * @param string $accion
     * @return hisDato
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

  
}