<?php

namespace App;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
            'routes'       => $this->getRoutes(),
            'console' => [
                'commands' => [
                    Seed\SeedCommand::class,
                ],
            ],
        ];
    }

    /**
     * Returns the container dependencies
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            'invokables' => [
                Action\PingAction::class => Action\PingAction::class,
            ],
            'factories'  => [
                Action\HomePageAction::class => Action\HomePageFactory::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     *
     * @return array
     */
    public function getTemplates()
    {
        return [
            'paths' => [
                'app'    => [__DIR__ . '/../templates/app'],
                // 'dms'    => [__DIR__ . '/../templates/dms'],
                'error'  => [__DIR__ . '/../templates/error'],
                'layout' => [__DIR__ . '/../templates/layout'],
            ],
        ];
    }


    public function getRoutes() : array
    {
        return [
            // Blog
            [
                'name'            => 'app::blog',
                'path'            => '/blog',
                'middleware'      => Action\BlogAction::class,
                'allowed_methods' => ['GET'],
            ],
            [
                'name'            => 'app::blog.view',
                'path'            => '/blog/{slug}',
                'middleware'      => Action\BlogViewAction::class,
                'allowed_methods' => ['GET'],
            ],
            [
                'name'            => 'app::faq',
                'path'            => '/faq',
                'middleware'      => Action\FaqAction::class,
                'allowed_methods' => ['GET'],
            ],
        ];
    }

}
