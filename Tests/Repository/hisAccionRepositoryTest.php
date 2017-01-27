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

class hisAccionRepositoryTest  extends  WebTestCase{

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
        $hisAccion->setFecha("test");
        $hisAccion->setHora("test");
        $hisAccion->setIdTipotraza($this->em->getRepository('TrazasBundle:nomTipotraza')->findOneBytipotraza('Accion'));
        $hisAccion->setRol("test");
        $hisAccion->setUsuario("test");
        $hisAccion->setControlador("test");
        $hisAccion->setFalla("test");
        $hisAccion->setInicio("test");
        $hisAccion->setReferencia("test");
        $this->em->persist($hisAccion);
        $this->em->flush();
        $taccion = $this->em
            ->getRepository('TrazasBundle:hisAccion')
            ->findByLimit(0,1);
        $this->assertCount(1, $taccion);
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
        $hisAccion->setIdTipotraza($this->em->getRepository('TrazasBundle:nomTipotraza')->findOneByTipotraza('Accion'));
        $hisAccion->setRol("test");
        $hisAccion->setUsuario("test");
        $hisAccion->setControlador("test");
        $hisAccion->setFalla("test");
        $hisAccion->setInicio("test");
        $hisAccion->setReferencia("test");
        $this->em->persist($hisAccion);
        $this->em->flush();

        $hisAccion2 = new hisAccion();
        $hisAccion2->setIpHost("test");
        $hisAccion2->setAccion("test");
        $hisAccion2->setFecha("1990-1-4");
        $hisAccion2->setHora("test");
        $hisAccion2->setIdTipotraza($this->em->getRepository('TrazasBundle:nomTipotraza')->findOneByTipotraza('Accion'));
        $hisAccion2->setRol("test");
        $hisAccion2->setUsuario("test");
        $hisAccion2->setControlador("test");
        $hisAccion2->setFalla("test");
        $hisAccion2->setInicio("test");
        $hisAccion2->setReferencia("test");
        $this->em->persist($hisAccion2);
        $this->em->flush();

        $taccion = $this->em
            ->getRepository('TrazasBundle:hisAccion')
            ->findbyFecha('1990-1-1','1990-1-3');
        $comp = array();
        foreach($taccion as  $p){
            if($p['usuario'] == 'test'){
                $comp[]=$p;
            }
        }
        $this->assertCount(1, $comp);
        $hisAccion2->setFecha("1990-1-2");
        $this->em->persist($hisAccion2);
        $this->em->flush();
        $taccion = $this->em
            ->getRepository('TrazasBundle:hisAccion')
            ->findbyFecha('1990-1-1','1990-1-3');
        $comp = array();
        foreach($taccion as  $p){
            if($p['usuario'] == 'test'){
                $comp[]=$p;
            }
        }
        $this->assertCount(2, $comp);
        $this->em->remove($hisAccion);
        $this->em->flush();
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
        $hisAccion->setIdTipotraza($this->em->getRepository('TrazasBundle:nomTipotraza')->findOneByTipotraza('Accion'));
        $hisAccion->setRol("test");
        $hisAccion->setUsuario("test");
        $hisAccion->setControlador("test");
        $hisAccion->setFalla("test");
        $hisAccion->setInicio("test");
        $hisAccion->setReferencia("test");
        $this->em->persist($hisAccion);
        $this->em->flush();

        $hisAccion2 = new hisAccion();
        $hisAccion2->setIpHost("test");
        $hisAccion2->setAccion("test");
        $hisAccion2->setFecha("1990-1-4");
        $hisAccion2->setHora("test");
        $hisAccion2->setIdTipotraza($this->em->getRepository('TrazasBundle:nomTipotraza')->findOneByTipotraza('Accion'));
        $hisAccion2->setRol("test");
        $hisAccion2->setUsuario("test");
        $hisAccion2->setControlador("test");
        $hisAccion2->setFalla("test");
        $hisAccion2->setInicio("test");
        $hisAccion2->setReferencia("test");
        $this->em->persist($hisAccion2);
        $this->em->flush();

        $hisAccion3 = new hisAccion();
        $hisAccion3->setIpHost("test");
        $hisAccion3->setAccion("test");
        $hisAccion3->setFecha("1990-1-1");
        $hisAccion3->setHora("test");
        $hisAccion3->setIdTipotraza($this->em->getRepository('TrazasBundle:nomTipotraza')->findOneByTipotraza('Accion'));
        $hisAccion3->setRol("test");
        $hisAccion3->setUsuario("test");
        $hisAccion3->setControlador("test");
        $hisAccion3->setFalla("test");
        $hisAccion3->setInicio("test");
        $hisAccion3->setReferencia("test");
        $this->em->persist($hisAccion3);
        $this->em->flush();

        $taccion = $this->em
            ->getRepository('TrazasBundle:hisAccion')
            ->findLimitByFecha('1990-1-1','1990-1-3',0,2);
        $comp = array();
        foreach($taccion as  $p){
            if($p['usuario'] == 'test'){
                $comp[]=$p;
            }
        }
        $this->assertCount(2, $comp);
        $hisAccion2->setFecha("1990-1-2");
        $this->em->persist($hisAccion2);
        $this->em->flush();
        $taccion = $this->em
            ->getRepository('TrazasBundle:hisAccion')
            ->findLimitByFecha('1990-1-1','1990-1-3',0,2);
        $comp = array();
        foreach($taccion as  $p){
            if($p['usuario'] == 'test'){
                $comp[]=$p;
            }
        }
        $this->assertCount(2, $comp);
        $this->em->remove($hisAccion);
        $this->em->remove($hisAccion2);
        $this->em->remove($hisAccion3);
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