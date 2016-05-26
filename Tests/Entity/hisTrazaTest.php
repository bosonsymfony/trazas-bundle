<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 26/06/15
 * Time: 12:02
 */

namespace UCI\Boson\TrazasBundle\Tests\Entity;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use UCI\Boson\TrazasBundle\Entity\hisAccion;

class hisTrazaTest extends WebTestCase {

    public static function setUpBeforeClass()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
    }

    public function testReferencia()
    {        $temp = new \DateTime("now");

        $hisTraza = new hisAccion();
        $hisTraza->setAccion('testAction');
        $hisTraza->setHora($temp->format('H:i'));
        $hisTraza->setIpHost('localhost');
        $hisTraza->setUsuario('daniel');
        $hisTraza->setInicio(1);
        $hisTraza->setReferencia('TestBundle');
        $hisTraza->setControlador('DefaultTest');
        $hisTraza->setFalla(1);
        $this->assertEquals('TestBundle', $hisTraza->getReferencia());
        $this->assertEquals('DefaultTest', $hisTraza->getControlador());
        $this->assertEquals('testAction', $hisTraza->getAccion());
        $this->assertEquals(1, $hisTraza->getFalla());
        $this->assertEquals(1, $hisTraza->getInicio());

    }
}
 