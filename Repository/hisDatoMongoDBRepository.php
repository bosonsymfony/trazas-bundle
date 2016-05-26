<?php

namespace UCI\Boson\TrazasBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;
/**
 * Class hisDatoRepository
 *
 * @author Daniel Arturo Casals Amat<dacasals@uci.cu>
 * @package TrazasBundle\Repository
 */
class hisDatoMongoDBRepository extends DocumentRepository {

    /**
     * Devuelve un array con las trazas de datos registradas entre el inicio y el límite especificado.
     * Responde al RF (87) Buscar trazas por tipo entre inicio y límite dado
     *
     * @param $start
     * @param $limit
     * @return array
     */
    public function findByLimit( $start, $limit) {

        $qb = $this->dm->getRepository('TrazasBundle:hisDato')->createQueryBuilder('trazas');
        $qb->skip($start)
            ->limit($limit);
        $result = $qb->getQuery()->toArray();
        return $result;
    }

    /**
     * Devuelve un array con las trazas de datos registradas entre la fecha de inicio y fin especificado.
     * Responde al RF (86) Buscar trazas por tipo dentro de un rango de de fechas
     *
     * @param $fechainicio
     * @param $fechafin
     * @return array
     */
    public function findbyFechas( $fechainicio, $fechafin) {
        $qb = $this->dm->getRepository('TrazasBundle:hisDato')->createQueryBuilder('trazas');
        return $qb
            ->field('fecha')->gte($fechainicio)
            ->field('fecha')->lte($fechafin)
            ->sort('fecha', 'DESC')
            ->sort('hora', 'DESC')
            ->getQuery()->toArray();
    }

    /**
     * Devuelve un array con las trazas de datos registradas entre las fechas de inicio y fin especificadas, teniendo en cuenta el inicio y límite especificado.
     * Responde al RF (88) Buscar trazas por tipo entre inicio, límite y rango de fechas
     *
     * @param $fechainicio
     * @param $fechafin
     * @param $start
     * @param $limit
     * @return array
     */
    public function findLimitByFecha( $fechainicio, $fechafin, $start, $limit) {
        $qb = $this->dm->getRepository('TrazasBundle:hisDato')->createQueryBuilder('trazas');
        return   $qb->field('fecha')->gte($fechainicio)
                    ->field('fecha')->lte($fechafin)
                    ->limit($limit)
                    ->skip($start)
                    ->sort('fecha', 'DESC')
                    ->sort('hora', 'DESC')
                    ->getQuery()->toArray();
    }

}
