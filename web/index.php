<?php

require_once('../vendor/autoload.php');

/*$app = new Silex\Application(); #https://silex.symfony.com/
$app['debug'] = true;

// Register the monolog logging service
$app->register(new Silex\Provider\MonologServiceProvider(), array(
  'monolog.logfile' => 'php://stderr',
));

// Register view rendering
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

// Our web handlers

$app->get('/', function() use($app) {
  $app['monolog']->addDebug('logging output.');
  return $app['twig']->render('index.html');
});

$app->run();*/
require_once('Router/Router.php');

$router =  new \App\Router\Router($_GET['url']);
$router->get('/', function(){echo 'Home pagel';});

$router->get('/posts', function(){echo "Lol";});
$router->get('/posts/:id', function ($id){echo 'article '.$id;});
$router->run();
