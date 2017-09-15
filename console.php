<?php // console.php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;

$container = require __DIR__ . '/config/container.php';
$application = new Application('Application console');

$commands = $container->get('config')['console']['commands'];
foreach ($commands as $command) {
    $application->add($container->get($command));
}

$application->run();
