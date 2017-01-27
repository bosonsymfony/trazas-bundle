<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 26/01/15
 * Time: 16:34
 */

namespace UCI\Boson\TrazasBundle\Tests\Repository;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use UCI\Boson\ExcepcionesBundle\Exception\LocalException;
use UCI\Boson\TrazasBundle\Entity\hisDato;

class hisDatoRepositoryTest  extends  WebTestCase{

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
        try{
            $hisDato = new hisDato();
            $hisDato->setIpHost("test");
            $hisDato->setAccion("test");
            $hisDato->setEsquema("test");
            $hisDato->setTabla("test");
            $hisDato->setFecha("test");
            $hisDato->setHora("test");
            $hisDato->setIdTipotraza($this->em->getRepository('TrazasBundle:nomTipotraza')->find(1));
            $hisDato->setRol("test");
            $hisDato->setUsuario("test");
            $this->em->persist($hisDato);
            $this->em->flush();
            $tdatos = $this->em
                ->getRepository('TrazasBundle:hisDato')
                ->findByLimit(0,1);
            $this->assertCount(1, $tdatos);
            $this->em->remove($hisDato);
            $this->em->flush();
        }
        catch(\Exception $e){
            $this->assertInstanceOf(LocalException::class,$e);
        }
    }

    public  function testFindbyFecha( ){
        try{
            $hisDato = new hisDato();
            $hisDato->setIpHost("test");
            $hisDato->setAccion("test");
            $hisDato->setEsquema("test");
            $hisDato->setTabla("test");
            $hisDato->setFecha("1990-1-1");
            $hisDato->setHora("test");
            $hisDato->setIdTipotraza($this->em->getRepository('TrazasBundle:nomTipotraza')->find(1));
            $hisDato->setRol("test");
            $hisDato->setUsuario("test");
            $this->em->persist($hisDato);
            $this->em->flush();

            $hisDato2 = new hisDato();
            $hisDato2->setIpHost("test");
            $hisDato2->setAccion("test");
            $hisDato2->setEsquema("test");
            $hisDato2->setTabla("test");
            $hisDato2->setFecha("1990-1-4");
            $hisDato2->setHora("test");
            $hisDato2->setIdTipotraza($this->em->getRepository('TrazasBundle:nomTipotraza')->find(1));
            $hisDato2->setRol("test");
            $hisDato2->setUsuario("test");
            $this->em->persist($hisDato2);
            $this->em->flush();
            $tdatos = $this->em->getRepository('TrazasBundle:hisDato')->findbyFechas('1990-1-1','1990-1-3');
            $comp = array();
            foreach($tdatos as  $p){
                if($p['usuario'] == 'test'){
                    $comp[]=$p;
                }
            }
            $this->assertCount(1, $comp);
            $hisDato2->setFecha('1990-1-2');
            $this->em->persist($hisDato2);
            $this->em->flush();
            $tdatos = $this->em->getRepository('TrazasBundle:hisDato')->findbyFechas('1990-1-1','1990-1-3');

            $comp2 = array();
            foreach($tdatos as  $p){
                if($p['usuario'] == 'test'){
                    $comp2[]=$p;
                }
            }
            $this->assertCount(2, $comp2);
            $this->em->remove($hisDato);
            $this->em->remove($hisDato2);
            $this->em->flush();
        }
        catch(\Exception $e){
            $this->assertInstanceOf(LocalException::class,$e);
        }

    }
    public  function testFindbyLimitByFecha( ){
        try{
            $hisDato = new hisDato();
            $hisDato->setIpHost("test");
            $hisDato->setAccion("test");
            $hisDato->setEsquema("test");
            $hisDato->setTabla("test");
            $hisDato->setFecha("1990-1-1");
            $hisDato->setHora("test");
            $hisDato->setIdTipotraza($this->em->getRepository('TrazasBundle:nomTipotraza')->find(1));
            $hisDato->setRol("test");
            $hisDato->setUsuario("test");
            $this->em->persist($hisDato);
            $this->em->flush();

            $hisDato2 = new hisDato();
            $hisDato2->setIpHost("test");
            $hisDato2->setAccion("test");
            $hisDato2->setEsquema("test");
            $hisDato2->setTabla("test");
            $hisDato2->setFecha("1990-1-4");
            $hisDato2->setHora("test");
            $hisDato2->setIdTipotraza($this->em->getRepository('TrazasBundle:nomTipotraza')->find(1));
            $hisDato2->setRol("test");
            $hisDato2->setUsuario("test");
            $this->em->persist($hisDato2);
            $this->em->flush();
            $tdatos = $this->em->getRepository('TrazasBundle:hisDato')->findbyFechas('1990-1-1','1990-1-3');
            $comp = array();
            foreach($tdatos as  $p){
                if($p['usuario'] == 'test'){
                    $comp[]=$p;
                }
            }
            $hisDato3 = new hisDato();
            $hisDato3->setIpHost("test");
            $hisDato3->setAccion("test");
            $hisDato3->setEsquema("test");
            $hisDato3->setTabla("test");
            $hisDato3->setFecha("1990-1-1");
            $hisDato3->setHora("test");
            $hisDato3->setIdTipotraza($this->em->getRepository('TrazasBundle:nomTipotraza')->find(1));
            $hisDato3->setRol("test");
            $hisDato3->setUsuario("test");
            $this->em->persist($hisDato3);
            $this->em->flush();

            $tdatos = $this->em->getRepository('TrazasBundle:hisDato')->findLimitByFecha('1990-1-1','1990-1-3',0,2);
            $comp = array();
            foreach($tdatos as  $p){
                if($p['usuario'] == 'test'){
                    $comp[]=$p;
                }
            }
            $this->assertCount(2, $comp);
            $hisDato2->setFecha('1990-1-2');
            $this->em->persist($hisDato2);
            $this->em->flush();
            $tdatos = $this->em->getRepository('TrazasBundle:hisDato')->findLimitByFecha('1990-1-1','1990-1-3',0,2);

            $comp2 = array();
            foreach($tdatos as  $p){
                if($p['usuario'] == 'test'){
                    $comp2[]=$p;
                }
            }
            $this->assertCount(2, $comp2);
            $this->em->remove($hisDato);
            $this->em->remove($hisDato2);
            $this->em->remove($hisDato3);
            $this->em->flush();
        }
        catch(\Exception $e){
            $this->assertInstanceOf(LocalException::class,$e);
        }

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