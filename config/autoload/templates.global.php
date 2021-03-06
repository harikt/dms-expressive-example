<?php

use Harikt\Blade\BladeRendererFactory;
use Zend\Expressive\Template\TemplateRendererInterface;

return [
    'dependencies' => [
        'factories' => [
            TemplateRendererInterface::class => BladeRendererFactory::class,
        ],
    ],

    'templates' => [
        'extension' => [
            'blade.php' => 'blade',
            'php' => 'php',
            'css' => 'file',
        ],
    ],

    'blade' => [
        'cache_dir'      => dirname(dirname(__DIR__)) . '/data/cache/blade',
        'assets_url'     => '/',
        'assets_version' => null,
        'extensions'     => [
            // extensions
        ],
        'runtime_loaders' => [
            // runtime loader names or instances
        ],
        'globals' => [
            // Variables to pass to all twig templates
        ],
        // 'timezone' => 'default timezone identifier; e.g. America/Chicago',
    ],
];
