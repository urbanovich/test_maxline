<?php

$loader = new \Phalcon\Loader();

$loader->registerNamespaces(
    [
        'TestMaxLine\Helpers'    => APP_PATH . '/helpers/',
        'TestMaxLine\Forms'    => APP_PATH . '/forms/',
        'TestMaxLine\Models'    => APP_PATH . '/models/',
    ]
);

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir
    ]
)->register();
