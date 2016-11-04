<?php
namespace UCI\Boson\TrazasBundle\EventListener;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\SecurityContext;
use UCI\Boson\ExcepcionesBundle\Exception\LocalException;
use UCI\Boson\TrazasBundle\Entity\hisAccion;
use UCI\Boson\TrazasBundle\Entity\hisRendimiento;
use Symfony\Component\HttpKernel\DataCollector\MemoryDataCollector;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;
use UCI\Boson\TrazasBundle\Entity\nomTipoTraza;

/**
 * Class AccionListener. Escucha los eventos necesarios para generar las trazas de acción y rendimiento.
 *
 * @author Daniel Arturo Casals Amat<dacasals@uci.cu>
 * @package UCI\Boson\TrazasBundle\EventListener
 */
class AccionListener
{
    /**
     * @var SecurityContext
     */
    private $securityContext;

    private $em;

    private $tipo;


    /**
     * @var bool
     */
    private $enableRendimiento;
    /**
     * @var null
     */
    static private $requests = null;

    static final function getInstance()
    {
        if (self::$requests == null) {
            self::$requests = array();
        }
    }


    /**
     * @param SecurityContext $securityContext
     * @param ManagerRegistry $managerRegistry
     * @param bool $enableRendimiento
     */
    public function __construct(TokenStorage $securityContext,ManagerRegistry $managerRegistry ,$enableRendimiento = false)
    {
        self::getInstance();
        $this->enableRendimiento = $enableRendimiento;
        $this->em = $managerRegistry->getManager("default");
        $this->securityContext = $securityContext;

    }

    /**
     * Evento que se ejecuta una vez que se ha generado un objeto Response.
     * Responde al RF(82) Generar trazas de acción.
     *
     * @param FilterResponseEvent $event
     * @return boolean
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();
        $request = $event->getRequest();
        $memory = new MemoryDataCollector();
        $memory->collect($request, $response);
        $memoria = $memory->getMemory();
        $tmp = new \DateTime("now");
        $params = $request->attributes->get('_controller');
        if (preg_match('/^web_profiler./', $params) != 1 &&
            $params != "twig.controller.exception:showAction" &&
            $params != null) {
            $this->em->getUnitOfWork()->clear();

            $fecha = $tmp->format('Y-m-d');
            $hora = $tmp->format('H:i');

            $IpHost = $request->getClientIp();

            $token = $this->securityContext->getToken();

            if($token instanceof AnonymousToken || $token == null){
                $Usuario = "IS_AUTHENTICATED_ANONYMOUSLY";
                $Rol = "";
            }
            else {
                $Usuario = $token->getUserName();
                $Rol = json_encode($token->getUser()->getRoles());
            }

            $arrayExplode = explode('Bundle\Controller\\', $params);
            /*
           * obtain controller as a normal way
           */
            if(count($arrayExplode) > 1){
                $Referencia = $arrayExplode[0] . 'Bundle';
                $control_accion = explode('::', $arrayExplode[1]);
                $Controlador = $control_accion[0];
                $Accion = $control_accion[1];
            /*
             * obtain controller in defined as services
             */
            }
            else if( count($arrayExplode) > 1 )
            {
                $arrayExplode = explode(':', $params);
                $control_accion = explode('::', $arrayExplode[1]);
                $Referencia = $control_accion[0];
                $Controlador = $control_accion[0];
                $Accion = $control_accion[1];
            }
            else{
                return false;
            }

            if ($response->isOk()) {
                $Inicio = 1;
                $Falla = 0;
            } else {
                $Inicio = 1;
                $Falla = 1;
            }
            $start = microtime(true);
            $var = array('fecha' => $fecha,
                'hora' => $hora,
                'ip' => $IpHost,
                'usuario' => $Usuario,
                'role' => $Rol,
                'referencia' => $Referencia,
                'controller' => $Controlador,
                'accion' => $Accion,
                'inicio' => $Inicio,
                'falla' => $Falla,
                'start' => $start,
                'memoria' => $memoria
            );
            self::$requests[] = array($request, $var);
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * Evento que se ejecuta una vez que se ha generado un objeto Response y ha sido enviado al cliente.
     * Responde al RF(84) (Generar trazas de rendimiento)
     *
     * @param PostResponseEvent $event
     */
    public function onKernelTerminate(PostResponseEvent $event)
    {
        $end = microtime(true);
        $request = $event->getRequest();
        foreach (self::$requests as $data) {
            if ($request == $data[0]) {
                $this->RegistrarAccion($data[1], $end);
            }
        }
    }

    /**
     * Perminte el registro de los datos de la acción requerida por el sistema y el rendimiento de la misma.
     *
     * @param $params array .Parámetros para el registro de la trazas de acción requerida.
     * @param $end int Tiempo del sistema en milisegundos en que se ejecuta el método onKernelTerminate
     * @throws LocalException
     */
    public function RegistrarAccion($params, $end)
    {

        if($this->em instanceof \Doctrine\ODM\MongoDB\DocumentManager){
            $this->tipo = $this->em->getRepository('TrazasBundle:nomTipotraza')->findOneBy(array('tipotraza'=>'Accion'));
            $accion = new \UCI\Boson\TrazasBundle\Document\hisAccion();
            $accion->setTipotraza($this->tipo);
        }
        else{
            $this->tipo = $this->em->getRepository('TrazasBundle:nomTipotraza')
                                   ->createQueryBuilder('a')->where('a.tipotraza = :tipo')
                                   ->setParameter('tipo','Accion')->getQuery()
                                   ->getOneOrNullResult();
            $accion = new \UCI\Boson\TrazasBundle\Entity\hisAccion();
            $accion->setIdTipotraza($this->tipo);
        }
        if ($this->tipo == null) {
            throw new LocalException("ERegistrarTipoAccion");
        }
        $accion->setFecha($params['fecha']);
        $accion->setHora($params['hora']);
        $accion->setIpHost($params['ip']);
        $accion->setUsuario($params['usuario']);
        $accion->setRol($params['role']);
        $accion->setReferencia($params['referencia']);
        $accion->setControlador($params['controller']);
        $accion->setAccion($params['accion']);
        $accion->setInicio($params['inicio']);
        $accion->setFalla($params['falla']);

        if($this->enableRendimiento ){
            if($this->em instanceof  \Doctrine\ODM\MongoDB\DocumentManager){
                $rendimiento = new \UCI\Boson\TrazasBundle\Document\hisRendimiento();
                $memory = memory_get_usage (true);
                $rendimiento->setMemoria($memory/1024);
                $tiempo = $end - $params['start'];
                $rendimiento->setTiempoEjecucion($tiempo);
                $accion->setRendimiento($rendimiento);
                try{
                    $this->em->persist($accion);
                    $this->em->clear($this->tipo);
                    $this->em->flush($accion);
                    return true;
                }catch (DBALException $ex){
                    throw new LocalException('ENotConexion',$ex);
                }
            }
            else{
                $this->em->persist($accion);
                
                //Esto genera problemas en las últimas versiones de doctrine probadas.
                //$this->em->clear($this->tipo);

                $this->em->flush($accion);
                $rendimiento = new hisRendimiento();
                $rendimiento->setAccion($accion);
                $memory = memory_get_usage (true);
                $rendimiento->setMemoria($memory/1024);
                $tiempo = $end - $params['start'];
                $rendimiento->setTiempoEjecucion($tiempo);
                try{
                    $this->em->persist($rendimiento);
                    $this->em->flush($rendimiento);
                    return true;
                }catch (DBALException $ex){
                    throw new LocalException('ENotConexion',$ex);
                }
            }

        }
    }
}