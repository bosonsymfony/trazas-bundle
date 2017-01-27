<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 19/01/15
 * Time: 13:41
 */

namespace UCI\Boson\TrazasBundle\Tests\EventListener;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ServerBag;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use UCI\Boson\ExcepcionesBundle\Exception\LocalException;
use UCI\Boson\TrazasBundle\Entity\hisDato;
use UCI\Boson\TrazasBundle\Entity\nomTipotraza;
use UCI\Boson\TrazasBundle\EventListener\DatoListener;

class DatoListenerTest  extends  WebTestCase{

    static $datoListener ;
    public static function setUpBeforeClass()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        static::$kernel->getContainer()->get('security.context')->setToken(new AnonymousToken("prueba","Anonymous",array()));

         static::$datoListener = new DatoListener(static::$kernel->getContainer());
    }

    public function testCheckNotTrazasEntity(){
        $hisDato = new hisDato();
        $this->assertFalse(static::$datoListener->checkNotTrazasEntity($hisDato),"Para esta entidad debe devolver false");
        $this->assertTrue(static::$datoListener->checkNotTrazasEntity(new nomTipotraza()),"Para esta entidad debe devolver true");
    }
    public function testCreateDato(){

        $cli = $this->createClient();
        $request= new Request();
         $request->server  = new ServerBag(array('REMOTE_ADDR'=> '127.0.0.1'));
        static::$datoListener->setRequest($request);
        $em = $cli->getContainer()->get('doctrine.orm.entity_manager');


        try{
            $datolleno = static::$datoListener->createDato($em, new nomTipotraza(),"Insert");
            $tmp = new \DateTime("now");

            $this->assertEquals($datolleno->getFecha(),$tmp->format('Y-m-d'));
            $this->assertEquals($datolleno->getAccion(),"Insert");
        }
        catch(\Exception $ex){
            $this->assertInstanceOf(LocalException::class,$ex);
        }
    }

    public function testCheckNoTrazasEntity()
    {

        $hisDato = new hisDato();
        $this->assertFalse(static::$datoListener->checkNotTrazasEntity($hisDato));
        $this->assertTrue(static::$datoListener->checkNotTrazasEntity(new \Exception()));
    }
}