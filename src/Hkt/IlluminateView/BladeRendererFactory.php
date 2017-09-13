<?php
namespace Hkt\IlluminateView;

use Interop\Container\ContainerInterface;
use Illuminate\View\Factory;

class BladeRendererFactory
{
    /**
     * @param ContainerInterface $container
     * @return BladeRenderer
     */
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->has('config') ? $container->get('config') : [];
        $config = isset($config['templates']) ? $config['templates'] : [];

        // Create the engine instance:
        $engine = $this->createEngine($container);

        // Set file extension
        // if (isset($config['extension'])) {
        //     $engine->addExtension($extension, $engine, $resolver = null);
        // }

        // Inject engine
        $blade = new BladeRenderer($engine);
        // Add template paths
        $allPaths = isset($config['paths']) && is_array($config['paths']) ? $config['paths'] : [];
        foreach ($allPaths as $namespace => $paths) {
            $namespace = is_numeric($namespace) ? null : $namespace;
            foreach ((array) $paths as $path) {
                $blade->addPath($namespace, $path);
            }
        }

        return $blade;
    }

    private function createEngine(ContainerInterface $container)
    {
        // Bug

        // if ($container->has(Factory::class)) {
        //     return $container->get(Factory::class);
        // }

        $engineFactory = new BladeEngineFactory();
        return $engineFactory($container);
    }
}
