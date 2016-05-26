<?php

namespace UCI\Boson\TrazasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template; //Debe quitarse
use Symfony\Component\HttpFoundation\Response;
use UCI\Boson\BackendBundle\Controller\BackendController;
use UCI\Boson\TrazasBundle\Entity\hisExcepcion;

/**
 * hisExcepcion controller.
 *
 * @Route("/hisexcepcion")
 */
class hisExcepcionController extends BackendController
{
    private $listFields = array(
        'fields' => array(
            'idTraza',
            'fecha',
            'hora',
            'usuario',
            'ipHost',
            'rol',
            'tipo',
            'mensaje',
        ),
        'associations' => array(
            'idTipotraza' => array(
                'fields' => array(
                    'idTipotraza',
                    'tipotraza',
                ),
                'associations' => array()
            ),
        )

    );

    private $searchFields = array(
        'idTraza' => 'integer',
        'fecha' => 'string',
        'hora' => 'string',
        'usuario' => 'string',
        'ipHost' => 'string',
        'rol' => 'string',
        'tipo' => 'string',
        'mensaje' => 'string',
    );

    private $newFormFields = array(
        'idTraza',
        'fecha',
        'hora',
        'usuario',
        'ipHost',
        'rol',
        'tipo',
        'mensaje',
    );

    private $editFormFields = array(
        'idTraza',
        'fecha',
        'hora',
        'usuario',
        'ipHost',
        'rol',
        'tipo',
        'mensaje',
    );

    private $defaultMaxResults = array(5, 10, 15);


    /**
     * Lists all hisExcepcion entities.
     *
     * @Route("/", name="hisexcepcion", options={"expose"=true})
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $filter = $request->get('filter', "");
        $limit = $request->get('limit', 5);
        $page = $request->get('page', 1);
        $order = $request->get('order', "id");
        return new Response($this->serialize($this->PaginateResults($filter, $page, $limit, $order)), 200, array(
            'content-type' => 'application/json'
        ));
    }
    /**
     * Creates a new hisExcepcion entity.
     *
     * @Route("/", name="hisexcepcion_create", options={"expose"=true})
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $entity = new hisExcepcion();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($entity);
            $em->flush();

            return new Response('The hisExcepcion was created successfully.');
        }

        $errors = $this->getAllErrorsMessages($form);
        return new Response($this->serialize($errors), Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Creates a form to create a hisExcepcion entity.
     *
     * @param hisExcepcion $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(hisExcepcion $entity)
    {
        $form = $this->get('form.factory')->createNamedBuilder('trazasbundle_hisexcepcion', 'form', $entity, array(
            //'csrf_protection'   => false
        ));

        foreach ($this->newFormFields as $index => $newFormField) {
            $form->add($newFormField);
        }
        $form->setAction($this->generateUrl('hisexcepcion_create'));

        return $form->getForm();
    }

    /**
     * Displays a form to create a new hisExcepcion entity.
     *
     * @Route("/new", name="hisexcepcion_new", options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new hisExcepcion();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Busca y muestra las ocurrencias de trazas de excepción
     * Responde a los RF(86-87) Buscar y Listar Trazas
     * @Route("/{id}", name="hisexcepcion_show", options={"expose"=true})
     * @Method("GET")
     */
    public function showAction($id)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $entity = $em->getRepository('TrazasBundle:hisExcepcion')->find($id);

        if (!$entity) {
            return new Response('Unable to find hisExcepcion entity.', Response::HTTP_NOT_FOUND);
        }

        return new Response($this->serialize($entity));
    }
                                                                                                                                                                                                                      /**
    * Creates a form to edit a hisExcepcion entity.
    *
    * @param hisExcepcion $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(hisExcepcion $entity)
    {
        $form = $this->get('form.factory')->createNamedBuilder('trazasbundle_hisexcepcion', 'form', $entity, array(
            //'csrf_protection' => false
        ));
        foreach ($this->editFormFields as $index => $editFormField) {
            $form->add($editFormField);
        }

        $form->setMethod('PUT');

        return $form->getForm();
    }

    /**
     * Edits an existing hisExcepcion entity.
     *
     * @Route("/{id}", name="hisexcepcion_update", options={"expose"=true})
     * @Method("PUT")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $entity = $em->getRepository('TrazasBundle:hisExcepcion')->find($id);

        if (!$entity) {
            return new Response('Unable to find hisExcepcion entity.', Response::HTTP_NOT_FOUND);
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return new Response('The Usuario was updated successfully.');
        }

        $errors = $this->getAllErrorsMessages($editForm);
        return new Response($this->serialize($errors), Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Elimina la traza de excepci'on
     * Responde al RF(88) Eliminar trazas por criterio de selección
     * @Route("/{id}", name="hisexcepcion_delete", options={"expose"=true})
     * @Method("DELETE")
     */
    public function deleteAction($id)
    {

        $em = $this->get('doctrine.orm.entity_manager');
        $entity = $em->getRepository('TrazasBundle:hisExcepcion')->find($id);

        if (!$entity) {
            return new Response('Unable to find hisExcepcion entity.', Response::HTTP_NOT_FOUND);
        }

        $em->remove($entity);
        $em->flush();

        return new Response("The hisExcepcion with id '$id' was deleted successfully.");
    }

    public function PaginateResults($filter = "", $page = 1, $limit = 5, $order = "id")
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $selectFields = "partial hisExcepcion.{" . implode(', ', $this->listFields['fields']) . "}";
        $selectAssociations = $this->generateSelect($this->listFields['associations'], 'hisExcepcion');
        $qb = $em->createQueryBuilder();

        list($limit, $order, $direction) = $this->transformQuery($limit, $order);

        $qb
            ->select($selectFields)
            ->from('TrazasBundle:hisExcepcion', 'hisExcepcion')
            ->orderBy('hisExcepcion.' . $order, $direction)
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        foreach ($selectAssociations['select'] as $selectAssociation) {
            $qb->addSelect($selectAssociation);
        }

        foreach ($selectAssociations['join'] as $index => $selectAssociation) {
            $qb->leftJoin($selectAssociation, $index);
        }

        foreach ($this->searchFields as $index => $searchField) {
            $like = ($searchField !== 'string') ? "CAST(hisExcepcion.$index AS TEXT)" : "LOWER(hisExcepcion.$index)";
            $qb->orWhere("$like LIKE '%$filter%'");
        }

        $query = $qb->getQuery();
        $query->setHint(Query::HINT_FORCE_PARTIAL_LOAD, true);
        $query->setHydrationMode(Query::HYDRATE_ARRAY);

        $paginator = new Paginator($query);
        $count = $paginator->count();

        return array(
            'data' => $paginator->getIterator()->getArrayCopy(),
            'count' => $count
        );
    }

    public function transformQuery($limit, $order)
    {
        $limit = (in_array($limit, $this->defaultMaxResults)) ? $limit : $this->defaultMaxResults[0];
        if ($this->startsWith($order, '-')) {
            return array($limit, substr($order, 1), 'DESC');
        } else {
            return array($limit, $order, 'ASC');
        }
    }

    public function startsWith($haystack, $needle)
    {
        // search backwards starting from haystack length characters from the end
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
    }

    /**
     * @param array $associations
     * @param $parent
     * @return array
     */
    private function generateSelect(array $associations, $parent)
    {
        $result = array(
            'select' => array(),
            'join' => array()
        );

        foreach ($associations as $index => $association) {
            $select = 'partial ' . $index . '.{' . implode(', ', $association['fields']) . '}';
            $result['select'][] = $select;
            $join = $parent . '.' . $index;
            $result['join'][$index] = $join;

            if (array_key_exists('associations', $association)) {
                $result = array_merge_recursive($result, $this->generateSelect($association['associations'], $index));
            }

        }

        return $result;
    }
}
