<?php

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;
use Doctrine\Common\Annotations\AnnotationRegistry;

// require Composer's autoloader
$loader = require __DIR__.'/../vendor/autoload.php';
// auto-load annotations
AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

class AppKernel extends Kernel
{
    use MicroKernelTrait;

    public function registerBundles()
    {
        /* Inicialmente vamos a trabajar con 3 bundles:
         * El Propio Framework, Twig
         * y Mejoras para controladores y demás.
         */
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            // se añade el SecurityBundle
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            // ...
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            // se añade el WebProfilerBundle
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
        }

        return $bundles;
    }

    protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config.yml');

        // Se añade la config del WebProfilerBundle, solo si el bundle fué cargado.
        if (isset($this->bundles['WebProfilerBundle'])) {
            $c->loadFromExtension('web_profiler', array(
                'toolbar' => true,
                'intercept_redirects' => false,
            ));
        }
    }

    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        // Importamos las rutas del WebProfilerBundle, solo si el bundle fué cargado.
        if (isset($this->bundles['WebProfilerBundle'])) {
            $routes->import('@WebProfilerBundle/Resources/config/routing/wdt.xml', '/_wdt');
            $routes->import('@WebProfilerBundle/Resources/config/routing/profiler.xml', '/_profiler');
        }
        
        // Cargamos los controllers usando anotaciones
        $routes->import(__DIR__.'/../src/App/Controller/', '/', 'annotation');
    }
}
