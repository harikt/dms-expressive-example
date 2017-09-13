<?php
/**
 * @see       https://github.com/zendframework/zend-expressive-platesrenderer for the canonical source repository
 * @copyright Copyright (c) 2016-2017 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   https://github.com/zendframework/zend-expressive-platesrenderer/blob/master/LICENSE.md New BSD License
 */

namespace Hkt\IlluminateView\Extension;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Helper\ServerUrlHelper;
use Zend\Expressive\Plates\Exception\MissingHelperException;

/**
 * Factory for creating a UrlExtension instance.
 */
class UrlExtensionFactory
{
    /**
     * @param ContainerInterface $container
     * @return UrlExtension
     * @throws MissingHelperException if UrlHelper service is missing.
     * @throws MissingHelperException if ServerUrlHelper service is missing.
     */
    public function __invoke(ContainerInterface $container)
    {
        if (! $container->has(UrlHelper::class)) {
            throw new MissingHelperException(sprintf(
                '%s requires that the %s service be present; not found',
                UrlExtension::class,
                UrlHelper::class
            ));
        }

        if (! $container->has(ServerUrlHelper::class)) {
            throw new MissingHelperException(sprintf(
                '%s requires that the %s service be present; not found',
                UrlExtension::class,
                ServerUrlHelper::class
            ));
        }

        return new UrlExtension(
            $container->get(UrlHelper::class),
            $container->get(ServerUrlHelper::class)
        );
    }
}
