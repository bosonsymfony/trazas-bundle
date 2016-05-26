<?php

namespace UCI\Boson\TrazasBundle\EventListener;

use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\SecurityContext;
use UCI\Boson\ExcepcionesBundle\Exception\LocalException;
use UCI\Boson\TrazasBundle\Entity\hisExcepcion;
use Exception;

/**
 * Class ExceptionListener. Escucha eventos de tipos kernel.excepction y para registrar trazas de excepciones producidas.
 *
 * @author Daniel Arturo Casals Amat<dacasals@uci.cu>
 * @package UCI\Boson\TrazasBundle\EventListener
 */
class ExceptionListener {

    /**
     * @var SecurityContext
     */
    private $securityContext;

    private $em;

    private $tipo;
    private $managerRegistry;

    /**
     * Constructor de la clase.
     *
     * @param TokenStorage $securityContext
     * @param EntityManager $em
     */
    public function __construct(TokenStorage $securityContext,ManagerRegistry $managerRegistry) {
        $this->securityContext = $securityContext;
        $this->em = $managerRegistry->getManager("default");
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * Escucha los eventos de tipo kernel.exception y hace la llamada al metodo de registro de trazas.
     * Responde al RF (85) Generar trazas de excepción
     *
     * @param GetResponseForExceptionEvent $event
     * @throws LocalException
     */
    public function onKernelException(GetResponseForExceptionEvent $event) {
        
        $exception = $event->getException();
        $request = $event->getRequest();

        $this->RegistrarExcepcion($exception, $request);
    }

    /**
     * Registra las datos de las trazas de tipo excepciones cada vez que se lanza el evento kernel.excepction.
     *
     * @param Exception $excep
     * @param Request $params
     * @throws LocalException
     */
    public function RegistrarExcepcion(Exception $excep, Request $params) {
        $this->em->getUnitOfWork()->clear();
        $tmp = new \DateTime("now");
        if($this->em instanceof \Doctrine\ODM\MongoDB\DocumentManager){
            $this->tipo = $this->em->getRepository('TrazasBundle:nomTipotraza')->findOneBy(array('tipotraza'=>'Excepcion'));
            if($this->tipo == null){
                throw new LocalException("ERegistrarTipoExcepcion");
            }
            $excepcion = new \UCI\Boson\TrazasBundle\Document\hisExcepcion();
            $excepcion->setTipotraza($this->tipo);
        }
        else{
            $this->tipo = $this->em->getRepository('TrazasBundle:nomTipotraza')
                ->createQueryBuilder('a')->where('a.tipotraza = :tipo')
                ->setParameter('tipo','Excepcion')->getQuery()
                ->getOneOrNullResult();
            if($this->tipo == null){
                throw new LocalException("ERegistrarTipoExcepcion");
            }
            $excepcion = new hisExcepcion();
            $excepcion->setIdTipotraza($this->tipo);
        }
        $excepcion->setFecha($tmp->format('Y-m-d'));
        $excepcion->setHora($tmp->format('H:i'));
        $excepcion->setIpHost($params->getClientIp());

        $token =$this->securityContext->getToken();

        if($token instanceof AnonymousToken || $token == null){
            $excepcion->setUsuario('IS_AUTHENTICATED_ANONYMOUSLY');
            $excepcion->setRol("");
        }
        else {
            $excepcion->setUsuario($token->getUserName());
            $excepcion->setRol(json_encode($token->getUser()->getRoles()));
        }

        if ($excep instanceof HttpException) {
            $excepcion->setMensaje($excep->getStatusCode().' '.$excep->getMessage());
        } else{
            $excepcion->setMensaje($excep->getMessage());
        }
        $tipo = explode('\\', get_class($excep));
        $excepcion->setTipo($tipo[count($tipo)-1]);
        try{

            $this->em->persist($excepcion);
            $this->em->flush();
        }
        catch(DBALException $ex){
            throw new LocalException("ENotConexion",$ex);
        }
        /**
         *  Si el manager is closed hay que resetear el manager
         */
        catch(ORMException $ex){
            try{

                $this->em->persist($excepcion);
                $this->em->flush();
            }
            catch(DBALException $ex){
                throw new LocalException("ENotConexion",$ex);
            }
        }
    }
}
