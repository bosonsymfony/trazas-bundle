<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 22/01/15
 * Time: 16:43
 */

namespace UCI\Boson\TrazasBundle\Tests\EventListener;

use Doctrine\DBAL\DBALException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use UCI\Boson\ExcepcionesBundle\Exception\LocalException;
use UCI\Boson\TrazasBundle\EventListener\AccionListener;

class AccionListenerTest extends WebTestCase
{
    static $accionListener;

    public static function setUpBeforeClass()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        static::$kernel->getContainer()->get('security.context')->setToken(new AnonymousToken("prueba", "Anonymous", array()));

        static::$accionListener = new AccionListener(static::$kernel->getContainer()->get('security.context'), static::$kernel->getContainer()->get('doctrine.orm.default_entity_manager'), "false");
    }

    public function testOnKernelResponse()
    {

        $cli = static::createClient();
        $tmp = new \DateTime("now");
        $fecha = $tmp->format('Y-m-d');
        $hora = $tmp->format('H:i');
        $request = $this->getMockBuilder("Symfony\\Component\\HttpFoundation\\Request")->getMock();


        $para = new ParameterBag(array("_controller" => "UCI\\Boson\\IUXBundle\\Controller\\iuxController::loadAction"));
        $request->attributes = $para;

        $event = new FilterResponseEvent($cli->getKernel(), $request, "Request", new Response()
        );

        $this->assertTrue(static::$accionListener->onKernelResponse($event));

    }

    public function testRegistrarAccion()
    {
        $temp = new \DateTime("now");
        $params = array('fecha' => $temp->format('Y-m-d'),
            'hora' => $temp->format('H:i'),
            'ip' => 'localhost',
            'usuario' => 'daniel',
            'role' => 'User',
            'referencia' => 'TestBundle',
            'controller' => 'DefaultTest',
            'accion' => 'testAction',
            'inicio' => 23,
            'falla' => 1,
            'start' => 1,
            'memoria' => 22
        );
        try{
            $respuetaBool = static::$accionListener->RegistrarAccion($params, 25);
            $this->assertTrue($respuetaBool);

        }
        catch(\Exception $ex){
            $this->assertInstanceOf(LocalException::class,$ex);
        }
    }
}