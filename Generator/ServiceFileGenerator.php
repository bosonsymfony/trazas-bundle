<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/4/14
 * Time: 10:09 a.m.
 */
namespace UCI\Boson\TrazasBundle\Generator;

use Sensio\Bundle\GeneratorBundle\Generator\Generator;

/**
 * Class ServiceFileGenerator. Se encarga de generar el fichero que configura los servicios que deben ser especificados
 * para que se registren las trazas teniendo en cuenta la configuración definida en el fichero config.yml en app.
 *
 * @author Daniel Arturo Casals Amat<dacasals@uci.cu>
 * @package UCI\Boson\TrazasBundle\Generator
 */
class ServiceFileGenerator  extends Generator{

    /**
     * Genera el fichero de configuración servicesListeners.yml que contiene la declaración de los listeners para el registro de las trazas.
     *
     * @param array $arrayTrazas
     * @param $paths
     */
    public function generate(array $arrayTrazas,$paths,$localDir = true){
    if($localDir){
        $namespace = strtr($paths.'\\Generator\\skeleton', '\\', '/');
        $this->setSkeletonDirs($namespace);

        $paths = $paths.'\\Resources\\config';
        $dir = strtr($paths, '\\', '/');
    }
    else{
        $namespace = strtr(__DIR__, '\\', '/').'/skeleton';
        $this->setSkeletonDirs($namespace);

        $paths = $paths.'\\Resources\\config';
        $dir = strtr($paths, '\\', '/');
    }
    if (file_exists($dir)) {
        if (!is_dir($dir)) {
            throw new \RuntimeException(sprintf('Unable to generate the service file as the target directory "%s" exists but is a file.', realpath($dir)));
        }
        if (!is_writable($dir)) {
            throw new \RuntimeException(sprintf('Unable to generate the service file  as the target directory "%s" is not writable.', realpath($dir)));
        }
    }
    try{
        $this->renderFile('services.yml.twig',$dir.'/servicesListeners.yml',$arrayTrazas);
    }
    catch(\Exception $e){
        var_dump($e->getMessage());
        throw new \RuntimeException(sprintf('Unable to generate the service file  as the target directory "%s" is not writable.', realpath($dir)));
    }

}

} 