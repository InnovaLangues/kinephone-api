<?php

$loader = require_once __DIR__ . '/../vendor/autoload.php';

$loader->add("app", dirname(__DIR__));

$app = new Silex\Application();
$app['debug'] = true;

/**
 * Register monolog services to handle log writing
 */
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__ . '/../app/logs/kinephone.log',
    'monolog.level' => Monolog\Logger::ERROR,
));

$app->register(new Silex\Provider\DoctrineServiceProvider(), array (
    'db.options' => array(
        'driver' => 'pdo_mysql',
        'dbhost' => 'localhost',
        'dbname' => 'kinephone21',
        'user'   => 'user',
        'password' => 'pass'
    )
));

$app->mount("/kinephones/languages", new app\Controller\LanguageController());

$app->mount("/kinephones/tables", new app\Controller\TableController());

$app->run();