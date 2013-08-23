<?php
// get the main config, add some service providers, return
$config = require(__DIR__ . '/../app.php');
$config['providers'][] = 'Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider';
$config['providers'][] = 'Way\Generators\GeneratorsServiceProvider';
return $config;
