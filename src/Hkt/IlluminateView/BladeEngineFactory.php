<?php
/**
 * @see       https://github.com/zendframework/zend-expressive-platesrenderer for the canonical source repository
 * @copyright Copyright (c) 2016-2017 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   https://github.com/zendframework/zend-expressive-platesrenderer/blob/master/LICENSE.md New BSD License
 */

namespace Hkt\IlluminateView;

use Interop\Container\ContainerInterface;
use Illuminate\Container\Container;
// use Illuminate\Events\Dispatcher;
// use Illuminate\Filesystem\Filesystem;
// use Illuminate\View\Compilers\BladeCompiler;
// use Illuminate\View\Engines\CompilerEngine;
// use Illuminate\View\Engines\EngineResolver;
// use Illuminate\View\Engines\PhpEngine;
// use Illuminate\View\Factory;
// use Illuminate\View\FileViewFinder;
use Illuminate\Contracts\View\Factory;

use Dms\Web\Expressive\View\DmsNavigationViewComposer;

class BladeEngineFactory
{
    /**
     * @param ContainerInterface $container
     * @return PlatesEngine
     */
    public function __invoke(ContainerInterface $container)
    {
        // $config = $container->has('config') ? $container->get('config') : [];
        // $config = isset($config['blade']) ? $config['blade'] : [];
		//
        // $pathsToTemplates = [];
        // $pathToCompiledTemplates = $config['cache_dir'];
        // // Dependencies
        // $filesystem = new Filesystem;
        // $eventDispatcher = new Dispatcher(new Container);
        // // Create View Factory capable of rendering PHP and Blade templates
        // $viewResolver = new EngineResolver;
        // $bladeCompiler = new BladeCompiler($filesystem, $pathToCompiledTemplates);
        // $viewResolver->register('blade', function () use ($bladeCompiler, $filesystem) {
        //     return new CompilerEngine($bladeCompiler, $filesystem);
        // });
        // $viewResolver->register('php', function () {
        //     return new PhpEngine;
        // });
        // $viewFinder = new FileViewFinder($filesystem, $pathsToTemplates);
        // $viewFactory = new Factory($viewResolver, $viewFinder, $eventDispatcher);

		$viewFactory = $container->get(Factory::class);

		// view()
		$viewFactory->composer('dms::template.default', DmsNavigationViewComposer::class);
        $viewFactory->composer('dms::dashboard', DmsNavigationViewComposer::class);
		$viewFactory->setContainer($container->getLaravelContainer());

        return $viewFactory;
    }

    /**
     * Inject the URL/ServerUrl extensions provided by this package.
     *
     * If a service by the name of the UrlExtension class exists, fetches
     * and loads it.
     *
     * Otherwise, instantiates the UrlExtensionFactory, and invokes it with
     * the container, loading the result into the engine.
     *
     * @param ContainerInterface $container
     * @param PlatesEngine $engine
     * @return void
     */
    private function injectUrlExtension(ContainerInterface $container, BladeCompiler $compiler)
    {
        // $container->get(ServerUrlHelper::class)

        // $compiler->directive('route', function ($expression) use ($container) {
        //     var_dump($expression);
        //     exit;
        //     $generator = $container->get(UrlHelper::class);
        // });
    }

    /**
     * Inject all configured extensions into the engine.
     * @param ContainerInterface $container
     * @param PlatesEngine $engine
     * @param array $extensions
     * @return void
     */
    private function injectExtensions(ContainerInterface $container, PlatesEngine $engine, array $extensions)
    {
        foreach ($extensions as $extension) {
            $this->injectExtension($container, $engine, $extension);
        }
    }

    /**
     * Inject an extension into the engine.
     *
     * Valid extension specifications include:
     *
     * - ExtensionInterface instances
     * - String service names that resolve to ExtensionInterface instances
     * - String class names that resolve to ExtensionInterface instances
     *
     * If anything else is provided, an exception is raised.
     *
     * @param ContainerInterface $container
     * @param PlatesEngine $engine
     * @param ExtensionInterface|string $extension
     * @return void
     * @throws Exception\InvalidExtensionException for non-string,
     *     non-extension $extension values.
     * @throws Exception\InvalidExtensionException for string $extension values
     *     that do not resolve to an extension instance.
     */
    private function injectExtension(ContainerInterface $container, PlatesEngine $engine, $extension)
    {
        if ($extension instanceof ExtensionInterface) {
            $engine->loadExtension($extension);
            return;
        }

        if (! is_string($extension)) {
            throw new Exception\InvalidExtensionException(sprintf(
                '%s expects extension instances, service names, or class names; received %s',
                __CLASS__,
                (is_object($extension) ? get_class($extension) : gettype($extension))
            ));
        }

        if (! $container->has($extension) && ! class_exists($extension)) {
            throw new Exception\InvalidExtensionException(sprintf(
                '%s expects extension service names or class names; "%s" does not resolve to either',
                __CLASS__,
                $extension
            ));
        }

        $extension = $container->has($extension)
            ? $container->get($extension)
            : new $extension();

        if (! $extension instanceof ExtensionInterface) {
            throw new Exception\InvalidExtensionException(sprintf(
                '%s expects extension services to implement %s ; received %s',
                __CLASS__,
                ExtensionInterface::class,
                (is_object($extension) ? get_class($extension) : gettype($extension))
            ));
        }

        $engine->loadExtension($extension);
    }
}
