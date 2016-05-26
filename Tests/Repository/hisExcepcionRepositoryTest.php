<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 26/01/15
 * Time: 16:34
 */

namespace UCI\Boson\TrazasBundle\Tests\Repository;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use UCI\Boson\TrazasBundle\Entity\hisExcepcion;

class hisExcepcionRepositoryTest  extends  WebTestCase{

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
        $hisExcepcion = new hisExcepcion();
        $hisExcepcion->setIpHost("test");
        $hisExcepcion->setFecha("test");
        $hisExcepcion->setHora("test");
        $hisExcepcion->setIdTipotraza($this->em->getRepository('TrazasBundle:nomTipotraza')->find(2));
        $hisExcepcion->setRol("test");
        $hisExcepcion->setUsuario("test");
        $hisExcepcion->setMensaje("test");
        $hisExcepcion->setTipo("test");
        $this->em->persist($hisExcepcion);
        $this->em->flush();
        $taccion = $this->em
            ->getRepository('TrazasBundle:hisExcepcion')
            ->findByLimit(0,1);
        $this->assertCount(1, $taccion);
        $this->em->remove($hisExcepcion);
        $this->em->flush();
    }
    public function testFindByFecha()
    {   $hisExcepcion = new hisExcepcion();
        $hisExcepcion->setIpHost("test");
        $hisExcepcion->setFecha("1990-1-1");
        $hisExcepcion->setHora("test");
        $hisExcepcion->setIdTipotraza($this->em->getRepository('TrazasBundle:nomTipotraza')->find(2));
        $hisExcepcion->setRol("test");
        $hisExcepcion->setUsuario("test");
        $hisExcepcion->setMensaje("test");
        $hisExcepcion->setTipo("test");
        $this->em->persist($hisExcepcion);
        $this->em->flush();

        $hisExcepcion2 = new hisExcepcion();
        $hisExcepcion2->setIpHost("test");
        $hisExcepcion2->setFecha("1990-1-4");
        $hisExcepcion2->setHora("test");
        $hisExcepcion2->setIdTipotraza($this->em->getRepository('TrazasBundle:nomTipotraza')->find(2));
        $hisExcepcion2->setRol("test");
        $hisExcepcion2->setUsuario("test");
        $hisExcepcion2->setMensaje("test");
        $hisExcepcion2->setTipo("test");
        $this->em->persist($hisExcepcion2);
        $this->em->flush();
        $tExc = $this->em->getRepository('TrazasBundle:hisExcepcion')->findbyFecha('1990-1-1','1990-1-3');
        $comp = array();
        foreach($tExc as  $p){
            if($p['usuario'] == 'test'){
                $comp[]=$p;
            }
        }
        $this->assertCount(1, $comp);
        $hisExcepcion2->setFecha('1990-1-2');
        $this->em->persist($hisExcepcion2);
        $this->em->flush();
        $tdatos = $this->em->getRepository('TrazasBundle:hisExcepcion')->findbyFecha('1990-1-1','1990-1-3');

        $comp2 = array();
        foreach($tdatos as  $p){
            if($p['usuario'] == 'test'){
                $comp2[]=$p;
            }
        }
        $this->assertCount(2, $comp2);
        $this->em->remove($hisExcepcion2);
        $this->em->remove($hisExcepcion);
        $this->em->flush();
    }
    public function testFindByLimitByFecha()
    {   $hisExcepcion = new hisExcepcion();
        $hisExcepcion->setIpHost("test");
        $hisExcepcion->setFecha("1990-1-1");
        $hisExcepcion->setHora("test");
        $hisExcepcion->setIdTipotraza($this->em->getRepository('TrazasBundle:nomTipotraza')->find(2));
        $hisExcepcion->setRol("test");
        $hisExcepcion->setUsuario("test");
        $hisExcepcion->setMensaje("test");
        $hisExcepcion->setTipo("test");
        $this->em->persist($hisExcepcion);
        $this->em->flush();

        $hisExcepcion2 = new hisExcepcion();
        $hisExcepcion2->setIpHost("test");
        $hisExcepcion2->setFecha("1990-1-4");
        $hisExcepcion2->setHora("test");
        $hisExcepcion2->setIdTipotraza($this->em->getRepository('TrazasBundle:nomTipotraza')->find(2));
        $hisExcepcion2->setRol("test");
        $hisExcepcion2->setUsuario("test");
        $hisExcepcion2->setMensaje("test");
        $hisExcepcion2->setTipo("test");
        $this->em->persist($hisExcepcion2);
        $this->em->flush();

        $hisExcepcion3 = new hisExcepcion();
        $hisExcepcion3->setIpHost("test");
        $hisExcepcion3->setFecha("1990-1-1");
        $hisExcepcion3->setHora("test");
        $hisExcepcion3->setIdTipotraza($this->em->getRepository('TrazasBundle:nomTipotraza')->find(2));
        $hisExcepcion3->setRol("test");
        $hisExcepcion3->setUsuario("test");
        $hisExcepcion3->setMensaje("test");
        $hisExcepcion3->setTipo("test");
        $this->em->persist($hisExcepcion3);
        $this->em->flush();


        $tExc = $this->em->getRepository('TrazasBundle:hisExcepcion')->findLimitByFecha('1990-1-1','1990-1-3',0,2);
        $comp = array();
        foreach($tExc as  $p){
            if($p['usuario'] == 'test'){
                $comp[]=$p;
            }
        }
        $this->assertCount(2, $comp);
        $hisExcepcion2->setFecha('1990-1-2');
        $this->em->persist($hisExcepcion2);
        $this->em->flush();
        $tdatos = $this->em->getRepository('TrazasBundle:hisExcepcion')->findLimitByFecha('1990-1-1','1990-1-3',0,2);

        $comp2 = array();
        foreach($tdatos as  $p){
            if($p['usuario'] == 'test'){
                $comp2[]=$p;
            }
        }
        $this->assertCount(2, $comp2);
        $this->em->remove($hisExcepcion2);
        $this->em->remove($hisExcepcion);
        $this->em->remove($hisExcepcion3);
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