<?php

namespace UCI\Boson\TrazasBundle\Repository;

use Doctrine\ORM\EntityRepository;
/**
 * Class hisRendimientoRepository. Repositorio de funcionaliades de acceso a datos para la tabla his_rendimiento
 *
 * @author Daniel Arturo Casals Amat<dacasals@uci.cu>
 * @package UCI\Boson\TrazasBundle\Repository
 */
class hisRendimientoRepository extends EntityRepository {

    /**
     * Devuelve un array con las trazas de rendimiento registradas entre el inicio y el límite especificado.
     * Responde al RF (87) Buscar trazas por tipo entre inicio y límite dado
     *
     * @param $start
     * @param $limit
     * @return array
     */
    public function findByLimit( $start, $limit) {

        $qb = $this->_em->getRepository('TrazasBundle:hisRendimiento')->createQueryBuilder('trazas');
        $qb->setFirstResult($start)
            ->setMaxResults($limit);
        $result = $qb->getQuery()->getArrayResult();
        return $result;
    }

    /**
     * Devuelve un array con las trazas de rendimiento registradas entre la fecha de inicio y fin especificado.
     * Responde al RF (86) Buscar trazas por tipo dentro de un rango de de fechas
     *
     * @param $fechainicio
     * @param $fechafin
     * @return array
     */
    public function findbyFecha( $fechainicio, $fechafin) {
        $qb = $this->_em->createQueryBuilder();
        $result = $qb->select('trazas')->from('TrazasBundle:hisRendimiento','trazas')
            ->join('trazas.idTraza','p')->where('p.fecha >= ?1 and p.fecha <= ?2' )
            ->setParameter(1, $fechainicio)
            ->setParameter(2, $fechafin)
            ->getQuery()->getArrayResult();
        return $result;
    }

    /**
     * Devuelve un array con las trazas de rendimiento registradas entre las fechas de inicio y fin especificadas, teniendo en cuenta el inicio y límite especificado.
     * Responde al RF (88) Buscar trazas por tipo entre inicio, límite y rango de fechas
     *
     * @param $fechainicio
     * @param $fechafin
     * @param $start
     * @param $limit
     * @return array
     */
    public function findLimitByFecha( $fechainicio, $fechafin, $start, $limit) {
        $qb = $this->_em->createQueryBuilder();
        $result = $qb->select('trazas')->from('TrazasBundle:hisRendimiento','trazas')
            ->join('trazas.idTraza','p')
            ->where('p.fecha >= ?1 and p.fecha <= ?2' )
            ->setParameter(1, $fechainicio)
            ->setParameter(2, $fechafin)
            ->setFirstResult($start)
            ->setMaxResults($limit)->getQuery()->getArrayResult();
        return $result;
    }

}
