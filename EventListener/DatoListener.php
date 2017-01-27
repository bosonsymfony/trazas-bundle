<?php

namespace UCI\Boson\TrazasBundle\EventListener;

use Doctrine\Common\EventArgs;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;

use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use UCI\Boson\ExcepcionesBundle\Exception\LocalException;
use UCI\Boson\TrazasBundle\Entity;
use UCI\Boson\TrazasBundle\Document;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;


/**
 * Class DatoListener
 *
 * @author Daniel Arturo Casals Amat<dacasals@uci.cu>
 * @package UCI\Boson\TrazasBundle\EventListener
 */
class DatoListener
{

    /**
     * @var
     */
    private $accion;

    /**
     * @var Container
     */
    private $container;

    protected $request;

    /**
     * Constructor de la clase.
     *
     * @param Container $container
     * @param string $doctrine_manager
     */
    public function __construct(Container $container, $doctrine_manager = "doctrine")
    {
        $this->container = $container;
        $this->doctrine_manager = $doctrine_manager;
    }


    public function setRequest(Request $request = null)
    {
        $this->request = $request;
    }

    /**
     * Se ejecuta después que se produce una persistencia de datos.
     * Responde al RF(83) Generar trazas de acceso a datos
     *
     * @param LifecycleEventArgs $args
     * @return boolean
     */
    public function onFlush(EventArgs $args)
    {
        $TareasInsert = $args->getEntityManager()->getUnitOfWork()->getScheduledEntityInsertions();
        $TareasUpdates = $args->getEntityManager()->getUnitOfWork()->getScheduledEntityUpdates();
        $TareasDeletes = $args->getEntityManager()->getUnitOfWork()->getScheduledEntityDeletions();

        foreach ($TareasInsert as $tInsert) {
            if ($this->checkNotTrazasEntity($tInsert)) {
                $this->RegistrarDato($args, $tInsert, "Insert");
            }
        }
        foreach ($TareasUpdates as $tUpdate) {
            if ($this->checkNotTrazasEntity($tUpdate)) {
                $this->RegistrarDato($args, $tUpdate, "Update");
            }
        }
        foreach ($TareasDeletes as $tDelete) {
            if ($this->checkNotTrazasEntity($tDelete)) {
                $this->RegistrarDato($args, $tDelete, "Delete");
            }
        }
    }

    public function checkNotTrazasEntity($entidad)
    {
        if ($this->doctrine_manager == "doctrine" && $entidad instanceof Entity\hisTraza ||
            $entidad instanceof Entity\hisAccion ||
            $entidad instanceof Entity\hisDato ||
            $entidad instanceof Entity\hisExcepcion ||
            $entidad instanceof Entity\hisRendimiento
        ) {
            return false;
        }
        else if ($this->doctrine_manager == "doctrine_mongodb" && $entidad instanceof Document\hisTraza ||
            $entidad instanceof Document\hisAccion ||
            $entidad instanceof Document\hisDato ||
            $entidad instanceof Document\hisExcepcion ||
            $entidad instanceof Document\hisRendimiento
        ) {
            return false;
        }
        return true;
    }


    /**
     * Registra las trazas de datos, cuando ocurre alguno de los eventos persist,update o remove.
     * Responde al RF(89) Generar trazas de acceso a datos
     *
     * @param EventArgs $args
     * @param $entity
     * @param $accion
     * @return bool
     * @throws LocalException
     */
    public function RegistrarDato(EventArgs $args, $entity, $accion)
    {
        $em = $this->container->get($this->doctrine_manager)->getManager();

        $dato = $this->createDato($em, $entity, $accion,$args);

        if ($dato instanceof Entity\hisDato) {

            /*Persistir la trazas, tiene que ser asi dentro de este evento*/
            $em->persist($dato);
            $em->getUnitOfWork()->computeChangeSets($em->getClassMetadata(get_class($dato)), $dato);
            $em->getUnitOfWork()->recomputeSingleEntityChangeSet($em->getClassMetadata(get_class($dato)), $dato);
        }
        elseif($dato instanceof Document\hisDato) {
            $em->persist($dato);
            $em->flush($dato);
        }
        else{
            return false;
        }
    }

    public function createDato($em, $entity, $accion,EventArgs $args)
    {

        if ($this->doctrine_manager == "doctrine_mongodb") {
            $dato = new Document\hisDato();
            $repo = $em->getRepository('TrazasBundle:nomTipotraza');
            $select = $repo->findOneBy(array('tipotraza'=>'Datos'));
            $dato->setTipotraza($select);


        } else {
            $repo = $em->getRepository('TrazasBundle:nomTipotraza');

            $select = $repo->createQueryBuilder('a')->where('a.tipotraza = :tipo')
                ->setParameter('tipo', 'Datos')->getQuery()->getOneOrNullResult();

            $dato = new Entity\hisDato();
            $dato->setIdTipotraza($select);

        }
        if ($this->request != null) {
            $dato->setIpHost($this->request->getClientIp());
        } else {
            $dato->setIpHost("Desconocido");
        }


        $tmp = new \DateTime("now");

        $dato->setFecha($tmp->format('Y-m-d'));
        $dato->setHora($tmp->format('H:i'));

        $token = $this->container->get('security.context')->getToken();
        if ($token == null) {
            return false;
        }
        if ($token instanceof AnonymousToken) {
            $dato->setUsuario('IS_AUTHENTICATED_ANONYMOUSLY');
            $dato->setRol("");
        } else {
            $dato->setUsuario($token->getUserName());
            $dato->setRol(json_encode($token->getUser()->getRoles()));
        }


        if ($select == null) {
            throw new LocalException("ERegistrarTipoDato");
        }
        /*para capturar el esquema y la tabla*/
        $name = $args->getEntityManager()->getClassMetadata(get_class($entity))->getTableName();
        $array = explode(".", $name);

        if (count($array) > 1) {
            $dato->setEsquema($array[0]);
            $dato->setTabla($array[1]);
        } else {
            $dato->setEsquema('public');
            $dato->setTabla($name);
        }
        $dato->setAccion($accion);
        return $dato;
    }
}
