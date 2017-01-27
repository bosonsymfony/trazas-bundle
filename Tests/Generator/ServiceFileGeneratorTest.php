<?php


namespace UCI\Boson\TrazasBundle\Tests\Generator;

use Sensio\Bundle\GeneratorBundle\Tests\Generator\GeneratorTest;
use UCI\Boson\TrazasBundle\Generator\ServiceFileGenerator;

class ServiceFileGeneratorTest extends GeneratorTest
{
//    public function testGenerate()
//    {
//        $this->getGenerator()->generate(array('accion', 'rendimiento'), $this->tmpDir, false, false);
//
//        $file = 'Resources/config/servicesListeners.yml';
//
//            $this->assertTrue(file_exists($this->tmpDir . '/Foo/BarBundle/' . $file), sprintf('%s has been generated', $file));
//
//        $content = file_get_contents($this->tmpDir . '/Foo/BarBundle/FooBarBundle.php');
//        $this->assertContains('namespace Foo\\BarBundle', $content);
//
//        $content = file_get_contents($this->tmpDir . '/Foo/BarBundle/Resources/config/servicesListeners.yml');
//        $this->assertContains('parameters:', $content);
//    }
//
//    public function testIsNotWritableDir()
//    {
//        $this->filesystem->mkdir($this->tmpDir . '/Foo/BarBundle');
//        $this->filesystem->chmod($this->tmpDir . '/Foo/BarBundle', 0444);
//        $array['accion'] = true;
//        $array['rendimiento'] = true;
//        $array['excepcion'] = true;
//        $array['datos'] = true;
//        $array['namespace'] = 'UCI\Boson';
//        try {
//            $this->getGenerator()->generate($array, $this->tmpDir, false);
//        } catch (\RuntimeException $e) {
//            $this->filesystem->chmod($this->tmpDir . '/Foo/BarBundle', 0777);
//            $this->assertEquals(sprintf('Unable to generate the bundle as the target directory "%s" is not writable.', realpath($this->tmpDir . '/Foo/BarBundle')), $e->getMessage());
//        }
//    }
//
//    public function testIsNotEmptyDir()
//    {
//        $this->filesystem->mkdir($this->tmpDir . '/Foo/BarBundle');
//        $this->filesystem->touch($this->tmpDir . '/Foo/BarBundle/somefile');
//        $array['accion'] = true;
//        $array['rendimiento'] = true;
//        $array['excepcion'] = true;
//        $array['datos'] = true;$array['namespace'] = 'UCI\Boson';
//        try {
//            $this->getGenerator()->generate($array, $this->tmpDir, false);
//        } catch (\RuntimeException $e) {
//            $this->filesystem->chmod($this->tmpDir . '/Foo/BarBundle', 0777);
//            $this->assertEquals(sprintf('Unable to generate the bundle as the target directory "%s" is not empty.', realpath($this->tmpDir . '/Foo/BarBundle')), $e->getMessage());
//        }
//    }
//
//
    /**
     * Si se mueve el bundle hay que actualizar la direccion de los skeletons
     *
     * @return ServiceFileGenerator
     */
    protected function getGenerator()
    {
        $generator = new ServiceFileGenerator($this->filesystem);
        $generator->setSkeletonDirs(
            array(__DIR__ . DIRECTORY_SEPARATOR .
                '..' . DIRECTORY_SEPARATOR .
                '..' . DIRECTORY_SEPARATOR .
                'Resources/skeleton'));
        return $generator;
    }

    public function testEsctructure()
    {
        $this->assertTrue(true);
//        $array['accion']  =true;
//        $array['rendimiento']  =true;
//        $array['excepcion']  =true;
//        $array['datos'] = true;$array['namespace'] = 'UCI\Boson';
//        $this->getGenerator()->generate($array, $this->tmpDir, false);
//        $this->assertTrue(file_exists($this->tmpDir . '/Foo/BarBundle/Resources/config/servicesListeners.yml'));

    }
}
