<?php
/**
 * Todo get rid of this
 */
if (! defined("PUBLIC_PATH")) {
    define('PUBLIC_PATH', dirname(dirname(__DIR__)) . '/public');
}
if (! defined("BASE_PATH")) {
    define('BASE_PATH', dirname(dirname(__DIR__)));
}
if (! defined("STORAGE_PATH")) {
    define('STORAGE_PATH', dirname(dirname(__DIR__)) . '/data');
}

use Zend\ConfigAggregator\ArrayProvider;
use Zend\ConfigAggregator\ConfigAggregator;
use Zend\ConfigAggregator\PhpFileProvider;

if (file_exists(dirname(__DIR__) . '/.env')) {
    $loader = new josegonzalez\Dotenv\Loader(dirname(__DIR__) . '/.env');
    // Parse the .env file
    $loader->parse();
    // Send the parsed .env file to the $_ENV variable
    $loader->putenv(true);
}

// To enable or disable caching, set the `ConfigAggregator::ENABLE_CACHE` boolean in
// `config/autoload/local.php`.
$cacheConfig = [
    'config_cache_path' => 'data/config-cache.php',
];

$aggregator = new ConfigAggregator([
    // Include cache configuration
    new ArrayProvider($cacheConfig),

    // Default App module config
    App\ConfigProvider::class,
    Dms\Web\Expressive\ConfigProvider::class,
    Dms\Cli\Expressive\ConfigProvider::class,

    // Load application config in a pre-defined order in such a way that local settings
    // overwrite global settings. (Loaded as first to last):
    //   - `global.php`
    //   - `*.global.php`
    //   - `local.php`
    //   - `*.local.php`
    new PhpFileProvider('config/autoload/{{,*.}global,{,*.}local}.php'),

    // Load development config if it exists
    new PhpFileProvider('config/development.config.php'),
], $cacheConfig['config_cache_path']);

return $aggregator->getMergedConfig();
