<?php

namespace UCI\Boson\TrazasBundle\Repository;

use Doctrine\ORM\EntityRepository;
/**
 * Class nomTipoTrazaRepository. Repositorio de consultas para la clase nomTipoTraza
 *
 * @author Daniel Arturo Casals Amat<dacasals@uci.cu>
 * @package UCI\Boson\TrazasBundle\Repository
 */
class nomTipoTrazaRepository extends EntityRepository {

    /**
     * Devuelve la tupla con el tipo de nomenclador requerido o null en caso de no existir.
     *
     * @param $tipo
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findbyTipo($em, $tipo) {
        $qb = $this->_em->getRepository('TrazasBundle:nomTipotraza')->createQueryBuilder('tipos');
        $qb->where('tipos.tipotraza = :tipo')
           ->setParameter("tipo", $tipo);
        $result = $qb->getQuery()->getOneOrNullResult();
        return $result;
    }
}
