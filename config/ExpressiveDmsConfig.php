<?php

namespace App;

use ArrayObject;
use Dms\Core\Ioc\IIocContainer;

/**
 * Configuration for the DMS Ioc Container.
 *
 * This class provides functionality for the following service types:
 *
 * - Aliases
 * - Delegators
 * - Factories
 * - Invokable classes
 * - Services (known instances)
 */
class ExpressiveDmsConfig
{

    protected $container;

    /**
     * @param array $config
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Configure the container
     *
     * - Adds the 'config' service.
     * - If delegators are defined, maps the service to lazyGetCall an
     *   ExpressiveAuraDelegatorFactory::build invocation using the configured
     *   delegator and whatever factory was responsible for it.
     * - If factories are defined, maps each factory class as a lazily
     *   instantiable service, and the service to lazyGetCall the factory to
     *   create the instance.
     * - If invokables are defined, maps each to lazyNew the target.
     * - If aliases are defined, maps each to lazyGet the target.
     */
    public function __invoke(array $config)
    {

        // Convert config to an object and inject it
        $this->container->bindCallback(IIocContainer::SCOPE_SINGLETON, 'config', function () use ($config) {
            return new ArrayObject($config, ArrayObject::ARRAY_AS_PROPS);
        });

        if (empty($config['dependencies'])) {
            return;
        }

        $dependencies = $config['dependencies'];

        // Inject delegator factories
        // This is done early because Aura.Di does not allow modification of a
        // service after creation. As such, we need to create custom factories
        // for each service with delegators.
        if (isset($dependencies['delegators'])) {
            $dependencies = $this->marshalDelegators($dependencies);
        }

        // Inject services
        if (isset($dependencies['services'])) {
            foreach ($dependencies['services'] as $name => $service) {
                // $this->container->set($name, $service);
                $this->container->bindValue(IIocContainer::SCOPE_SINGLETON, $name, $service);
            }
        }

        // Inject factories
        if (isset($dependencies['factories'])) {
            foreach ($dependencies['factories'] as $service => $factory) {
                // $this->container->set($factory, $this->container->lazyNew($factory));
                // $this->container->set($service, $this->container->lazyGetCall($factory, '__invoke', $this->container));
                $this->container->bindCallback(IIocContainer::SCOPE_SINGLETON, $service, function() use($factory) {
                    $f = $this->container->get($factory);
                    return $f($this->container);
                });
            }
        }

        // Inject invokables
        if (isset($dependencies['invokables'])) {
            foreach ($dependencies['invokables'] as $service => $class) {
                // $this->container->set($service, $this->container->lazyNew($class));
                $this->container->bindCallback(IIocContainer::SCOPE_SINGLETON, $service, function() use($class) {
                    return new $class();
                });
            }
        }

        // Inject aliases
        if (isset($dependencies['aliases'])) {
            foreach ($dependencies['aliases'] as $alias => $target) {
                // $this->container->set($alias, $this->container->lazyGet($target));
                $this->container->alias($target, $alias);
            }
        }
    }

    /**
     * Marshal all services with delegators.
     *
     * @param Container $this->container
     * @param array $dependencies
     * @return array List of dependencies minus any services, factories, or
     *     invokables that match services using delegator factories.
     */
    private function marshalDelegators(array $dependencies)
    {
        var_dump($dependencies['delegators']);
        exit;
        foreach ($dependencies['delegators'] as $service => $delegatorNames) {
            // $factory = null;
            //
            // if (isset($dependencies['services'][$service])) {
            //     // Marshal from service
            //     $instance = $dependencies['services'][$service];
            //     $factory = function () use ($instance) {
            //         return $instance;
            //     };
            //     unset($dependencies['service'][$service]);
            // }
            //
            // if (isset($dependencies['factories'][$service])) {
            //     // Marshal from factory
            //     $serviceFactory = $dependencies['factories'][$service];
            //     $factory = function () use ($service, $serviceFactory, $this->container) {
            //         return $serviceFactory($this->container, $service);
            //     };
            //     unset($dependencies['factories'][$service]);
            // }
            //
            // if (isset($dependencies['invokables'][$service])) {
            //     // Marshal from invokable
            //     $class = $dependencies['invokables'][$service];
            //     $factory = function () use ($class) {
            //         return new $class();
            //     };
            //     unset($dependencies['invokables'][$service]);
            // }
            //
            // if (! is_callable($factory)) {
            //     continue;
            // }

            // $delegatorFactory = new ExpressiveAuraDelegatorFactory($delegatorNames, $factory);
            // $this->container->set(
            //     $service,
            //     $this->container->lazyGetCall($delegatorFactory, 'build', $this->container, $service)
            // );
        }

        return $dependencies;
    }
}
