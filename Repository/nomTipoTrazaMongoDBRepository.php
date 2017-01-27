<?php

namespace UCI\Boson\TrazasBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;
/**
 * Class nomTipoTrazaRepository. Repositorio de consultas para la clase nomTipoTraza
 *
 * @author Daniel Arturo Casals Amat<dacasals@uci.cu>
 * @package UCI\Boson\TrazasBundle\Repository
 */
class nomTipoTrazaMongoDBRepository extends DocumentRepository {

    /**
     * findByTipo. Devuelve la tupla con el tipo de nomenclador requerido o null en caso de no existir.
     *
     * @param string $tipo
     *
     * @return \UCI\Boson\TrazasBundle\Document\nomTipotraza
     */
    public function findByTipo($tipo) {
        return $this->findOneBy(array('tipotraza' => $tipo));
    }
}
