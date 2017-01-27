<?php

namespace UCI\Boson\TrazasBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;

/**
 * Class hisTrazaRepository
 * 
 * @author René Leandro Cruz Laguna <rlcruz@uci.cu>
 * 
 */
class hisTrazaRepository extends DocumentRepository {

    /**
     * findByLimit
     *
     * @param int $start
     * @param int $limit
     * 
     * @return  UCI\Boson\TrazasBundle\Document\hisTraza[]
     */
    public function findByLimit($start = null, $limit = null) {

        return $this->findBy(array(), array('fecha' => 'DESC', 'hora' => 'DESC'), $limit, $start);
    }

    /**
     * findByRangoFecha
     *
     * @param string $fechaInicial
     * @param string $fechaFinal
     * @param int $start
     * @param int $limit
     * 
     * @return  UCI\Boson\TrazasBundle\Document\hisTraza[]
     */
    public function findByRangoFecha($fechaInicial, $fechaFinal, $start = null, $limit = null) {
        return $this->createQueryBuilder()
                        ->field('fecha')->gte($fechaInicial)
                        ->field('fecha')->lte($fechaFinal)
                        ->limit($limit)
                        ->skip($start)
                        ->sort('fecha', 'DESC')
                        ->sort('hora', 'DESC')
                        ->getQuery()->toArray();
    }

}
