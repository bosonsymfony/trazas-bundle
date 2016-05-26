<?php

namespace UCI\Boson\TrazasBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UCI\Boson\BackendBundle\Controller\BackendController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Dumper;
use UCI\Boson\TrazasBundle\Entity\Data;
use UCI\Boson\TrazasBundle\Form\DataType;

class ConfigController extends BackendController
{

    /**
     * Carga los diferentes tipos de trazas y su estado de activación
     * Responde al RF(85) Listar tipos de trazas
     * @return mixed
     * @Route(path="/trazas/currentinfo", name="trazas_current_info", options={"expose"=true})
     */
    public function showCurrentInfoAction()
    {
        $values = $this->readYAMLAction();
        $arr = $values['trazas']['types'];
        $response = new JsonResponse($arr);
        return $response;
    }

    /**
     * Lee la configuración del fichero de trazas
     * @return mixed
     */
    public function readYAMLAction()
    {
        $yaml = new Parser();
        $params = array(
            'bundle' => 'trazas'
        );
        $dirInicial = $this->container->get("kernel")->getRootDir() . '/config/config.yml';
        $dirTrazas = $this->findFileConfig($dirInicial, $params);
        $values = $yaml->parse(file_get_contents($dirTrazas));
        return $values;
    }

    /**
     * Devuelve la ruta del fichero de configuración de trazas dado una ruta inicial de configuración
     * y un arreglo con el nombre del componente a buscar
     * @param string $route
     * @param mixed $params
     * @return bool|null|string
     */
    private function findFileConfig($route = null, $params)
    {

        $yaml = new Parser();
        $recursos = $yaml->parse(file_get_contents($route));
        if (array_key_exists($params['bundle'], $fileParsed = $recursos)) {
            return $route;
        } else {
            if (!array_key_exists('imports', $recursos)) {
                return false;
            }
            foreach ($recursos['imports'] as $recurso) {
                $arrayParts = explode(DIRECTORY_SEPARATOR,
                    $recurso['resource']);
                $urlResource = $arrayParts[0];
                if (substr($urlResource, 0, 1) == "@") {
                    $dirBundle = substr($urlResource, 1);
                    unset($arrayParts[0]);
                    $urlResource =
                        $this->container->get("kernel")->getBundle($dirBundle)->getPath() . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $arrayParts);
                } else {
                    $arrayRouteParts = explode(DIRECTORY_SEPARATOR,
                        $route);
                    $urlResource =
                        explode($arrayRouteParts[count($arrayRouteParts) - 1], $route)[0] .
                        $urlResource;
                }
                if ($rutaResp = $this->findFileConfig($urlResource,
                    $params)
                ) {
                    return $rutaResp;
                } else {
                    continue;
                }
            }
        }
    }

    /**
     * Escribe la configuración de trazas en el fichero correspondiente
     * Responde al RF(84) Activar o desactivar Trazas
     * @Route(path="/trazas/saveData", name="trazas_save_data", options={"expose"=true})
     * @Method("POST")
     * @param Request $request
     * @return Response
     */
    public function writeYAMLAction(Request $request)
    {
        $data = new Data();
        $form = $this->createForm(new DataType(), $data);
        $form->handleRequest($request);

        $yaml = $this->readYAMLAction();
        $dumper = new Dumper();

        if ($form->isValid()) {
            if ($data->getAction() == "true") {
                $yaml['trazas']['types']['action'] = true;
            } else {
                $yaml['trazas']['types']['action'] = false;
            }

            if ($data->getData() == "true") {
                $yaml['trazas']['types']['data'] = true;
            } else {
                $yaml['trazas']['types']['data'] = false;
            }

            if ($data->getException() == "true") {
                $yaml['trazas']['types']['exception'] = true;
            } else {
                $yaml['trazas']['types']['exception'] = false;
            }

            if ($data->getPerformance() == "true") {
                $yaml['trazas']['types']['performance'] = true;
            } else {
                $yaml['trazas']['types']['performance'] = false;
            }

            $params = array(
                'bundle' => 'trazas'
            );
            $dirInicial = $this->container->get("kernel")->getRootDir() . '/config/config.yml';
            $dirTrazas = $this->findFileConfig($dirInicial, $params);
            $yaml_dump = $dumper->dump($yaml, 6);
            file_put_contents($dirTrazas, $yaml_dump);
            return new Response();
        }
    }


}
