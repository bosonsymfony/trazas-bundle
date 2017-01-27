<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 26/01/15
 * Time: 16:34
 */

namespace UCI\Boson\TrazasBundle\Tests\Repository;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use UCI\Boson\TrazasBundle\Entity\hisAccion;
use UCI\Boson\TrazasBundle\Entity\hisRendimiento;

class hisRendimientoRepositoryTest  extends  WebTestCase{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
        ;
    }
    public function testFindByLimit()
    {
        $hisAccion = new hisAccion();
        $hisAccion->setIpHost("test");
        $hisAccion->setAccion("test");
        $hisAccion->setFecha("1990-1-1");
        $hisAccion->setHora("test");
        $hisAccion->setIdTipotraza($this->em->getRepository('TrazasBundle:nomTipotraza')->find(3));
        $hisAccion->setRol("test");
        $hisAccion->setUsuario("test");
        $hisAccion->setControlador("test");
        $hisAccion->setFalla("test");
        $hisAccion->setInicio("test");
        $hisAccion->setReferencia("test");
        $this->em->persist($hisAccion);
        $this->em->flush();


        $hisRendimiento = new hisRendimiento();
        $hisRendimiento->setIdTraza($hisAccion);
        $hisRendimiento->setMemoria("000");
        $hisRendimiento->setTiempoEjecucion(000);
        $this->em->persist($hisRendimiento);
        $this->em->flush();
        $trendimiento = $this->em
            ->getRepository('TrazasBundle:hisRendimiento')
            ->findByLimit(0,1);
        $this->assertCount(1, $trendimiento);
        $this->em->remove($hisRendimiento);
        $this->em->remove($hisAccion);
        $this->em->flush();
    }
    
    public function testFindByFecha()
    {
        $hisAccion = new hisAccion();
        $hisAccion->setIpHost("test");
        $hisAccion->setAccion("test");
        $hisAccion->setFecha("1990-1-1");
        $hisAccion->setHora("test");
        $hisAccion->setIdTipotraza($this->em->getRepository('TrazasBundle:nomTipotraza')->find(3));
        $hisAccion->setRol("test");
        $hisAccion->setUsuario("test");
        $hisAccion->setControlador("test");
        $hisAccion->setFalla("test");
        $hisAccion->setInicio("test");
        $hisAccion->setReferencia("test");
        $this->em->persist($hisAccion);
        $this->em->flush();


        $hisRendimiento = new hisRendimiento();
        $hisRendimiento->setIdTraza($hisAccion);
        $hisRendimiento->setMemoria("000");
        $hisRendimiento->setTiempoEjecucion(000);
        $this->em->persist($hisRendimiento);
        $this->em->flush();

        $hisAccion2 = new hisAccion();
        $hisAccion2->setIpHost("test");
        $hisAccion2->setAccion("test");
        $hisAccion2->setFecha("1990-1-4");
        $hisAccion2->setHora("test");
        $hisAccion2->setIdTipotraza($this->em->getRepository('TrazasBundle:nomTipotraza')->find(3));
        $hisAccion2->setRol("test");
        $hisAccion2->setUsuario("test");
        $hisAccion2->setControlador("test");
        $hisAccion2->setFalla("test");
        $hisAccion2->setInicio("test");
        $hisAccion2->setReferencia("test");
        $this->em->persist($hisAccion2);
        $this->em->flush();


        $hisRendimiento2 = new hisRendimiento();
        $hisRendimiento2->setIdTraza($hisAccion2);
        $hisRendimiento2->setMemoria("000");
        $hisRendimiento2->setTiempoEjecucion(000);
        $this->em->persist($hisRendimiento2);
        $this->em->flush();

        $trendimiento = $this->em
            ->getRepository('TrazasBundle:hisRendimiento')
            ->findbyFecha('1990-1-1', '1990-1-3');
        $this->assertCount(1, $trendimiento);

        $hisAccion2->setFecha('1990-1-2');
        $this->em->persist($hisAccion2);
        $this->em->flush();

        $trendimiento = $this->em
            ->getRepository('TrazasBundle:hisRendimiento')
            ->findbyFecha('1990-1-1', '1990-1-3');

        $this->assertCount(2, $trendimiento);

        $this->em->remove($hisRendimiento);
        $this->em->remove($hisAccion);
        $this->em->remove($hisRendimiento2);
        $this->em->remove($hisAccion2);
        $this->em->flush();
    }

    public function testFindByLimitByFecha()
    {
        $hisAccion = new hisAccion();
        $hisAccion->setIpHost("test");
        $hisAccion->setAccion("test");
        $hisAccion->setFecha("1990-1-1");
        $hisAccion->setHora("test");
        $hisAccion->setIdTipotraza($this->em->getRepository('TrazasBundle:nomTipotraza')->find(3));
        $hisAccion->setRol("test");
        $hisAccion->setUsuario("test");
        $hisAccion->setControlador("test");
        $hisAccion->setFalla("test");
        $hisAccion->setInicio("test");
        $hisAccion->setReferencia("test");
        $this->em->persist($hisAccion);
        $this->em->flush();


        $hisRendimiento = new hisRendimiento();
        $hisRendimiento->setIdTraza($hisAccion);
        $hisRendimiento->setMemoria("000");
        $hisRendimiento->setTiempoEjecucion(000);
        $this->em->persist($hisRendimiento);
        $this->em->flush();

        $hisAccion3 = new hisAccion();
        $hisAccion3->setIpHost("test");
        $hisAccion3->setAccion("test");
        $hisAccion3->setFecha("1990-1-1");
        $hisAccion3->setHora("test");
        $hisAccion3->setIdTipotraza($this->em->getRepository('TrazasBundle:nomTipotraza')->find(3));
        $hisAccion3->setRol("test");
        $hisAccion3->setUsuario("test");
        $hisAccion3->setControlador("test");
        $hisAccion3->setFalla("test");
        $hisAccion3->setInicio("test");
        $hisAccion3->setReferencia("test");
        $this->em->persist($hisAccion3);
        $this->em->flush();


        $hisRendimiento3 = new hisRendimiento();
        $hisRendimiento3->setIdTraza($hisAccion3);
        $hisRendimiento3->setMemoria("000");
        $hisRendimiento3->setTiempoEjecucion(000);
        $this->em->persist($hisRendimiento3);
        $this->em->flush();

        $hisAccion2 = new hisAccion();
        $hisAccion2->setIpHost("test");
        $hisAccion2->setAccion("test");
        $hisAccion2->setFecha("1990-1-4");
        $hisAccion2->setHora("test");
        $hisAccion2->setIdTipotraza($this->em->getRepository('TrazasBundle:nomTipotraza')->find(3));
        $hisAccion2->setRol("test");
        $hisAccion2->setUsuario("test");
        $hisAccion2->setControlador("test");
        $hisAccion2->setFalla("test");
        $hisAccion2->setInicio("test");
        $hisAccion2->setReferencia("test");
        $this->em->persist($hisAccion2);
        $this->em->flush();


        $hisRendimiento2 = new hisRendimiento();
        $hisRendimiento2->setIdTraza($hisAccion2);
        $hisRendimiento2->setMemoria("000");
        $hisRendimiento2->setTiempoEjecucion(000);
        $this->em->persist($hisRendimiento2);
        $this->em->flush();

        $trendimiento = $this->em
            ->getRepository('TrazasBundle:hisRendimiento')
            ->findLimitByFecha('1990-1-1', '1990-1-3',0,2);
        $this->assertCount(2, $trendimiento);

        $hisAccion2->setFecha('1990-1-2');
        $this->em->persist($hisAccion2);
        $this->em->flush();

        $trendimiento = $this->em
            ->getRepository('TrazasBundle:hisRendimiento')
            ->findLimitByFecha('1990-1-1', '1990-1-3',0,2);

        $this->assertCount(2, $trendimiento);

        $this->em->remove($hisRendimiento);
        $this->em->remove($hisAccion);
        $this->em->remove($hisRendimiento3);
        $this->em->remove($hisAccion3);
        $this->em->remove($hisRendimiento2);
        $this->em->remove($hisAccion2);
        $this->em->flush();
    }
    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
//        $this->em->close();
    }
} 