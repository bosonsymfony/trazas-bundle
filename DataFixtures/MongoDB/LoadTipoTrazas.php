<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 16/01/15
 * Time: 19:47
 */

namespace UCI\Boson\TrazasBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use UCI\Boson\TrazasBundle\Document\nomTipotraza;

/**
 * Class LoadTipoTrazas. Carga en la base de datos los tipos de trazas existentes..
 *
 * @author René Leandro Cruz Laguna<rlcruz@uci.cu>
 * @package UCI\Boson\TrazasBundle\DataFixtures\MongoDB
 */
class LoadTipoTrazas implements FixtureInterface{
    /**
     * Carga en la tabla nomTipoTrazas los tipos de trazas existentes. Si se añade algún otro se debe incluir en el arreglo $tipos.
     *
     * @param Doctrine\Common\Persistence\ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $tipos = array("Datos","Excepcion","Accion","Rendimiento");
        
        foreach($tipos as $tipo){
            $tipoNew = new nomTipotraza();
            $tipoNew->setTipotraza($tipo);
            $manager->persist($tipoNew);
            $manager->flush();
        }

    }


} 