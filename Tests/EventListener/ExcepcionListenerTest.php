<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 22/01/15
 * Time: 16:49
 */

namespace UCI\Boson\TrazasBundle\Tests\EventListener;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Validator\Exception\InvalidArgumentException;
use UCI\Boson\ExcepcionesBundle\Exception\LocalException;
use UCI\Boson\TrazasBundle\Entity\hisDato;
use UCI\Boson\TrazasBundle\EventListener\ExceptionListener;
class ExcepcionListenerTest  extends WebTestCase{

    static $excpListener ;
    public static function setUpBeforeClass()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        static::$kernel->getContainer()->get('security.context')->setToken(new AnonymousToken("prueba","Anonymous",array()));

        static::$excpListener = new ExceptionListener(static::$kernel->getContainer()->get('security.context'),static::$kernel->getContainer()->get('doctrine')->getManager());
    }

    public function testRegistroTraza(){

        $ex = new \Exception('Hola');
        $cli = static::createClient();
        $tmp = new \DateTime("now");
        $fecha = $tmp->format('Y-m-d');
        $hora = $tmp->format('H:i');
        $request = new Request();
        try {
            $cli->request("GET","/testqweqweqwe/asd/");
        }catch (\Exception $e){
            $request = $cli->GetRequest();
        }
        try{
            static::$excpListener->RegistrarExcepcion($ex,$request);

            $excepciones = $cli->getContainer()->get('doctrine')->getManager()->
            getRepository('TrazasBundle:hisExcepcion')->findAll();
            $cantidad = count($excepciones);
            $excepcionesPost = $cli->getContainer()->get('doctrine')->getManager()->
            getRepository('TrazasBundle:hisExcepcion')->findAll();
            $cantidadPost = count($excepcionesPost);
            $this->assertTrue($cantidadPost > $cantidad);

        }
        catch(\Exception $ex){
            $this->assertInstanceOf(LocalException::class,$ex);
        }
    }



} 