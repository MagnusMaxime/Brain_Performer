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
require_once ('Controller/HomeController.php');
require_once ('Controller/ProfilController.php');

#Router de Graphikart : https://www.youtube.com/watch?v=I-DN2C7Gs7A
$router =  new \App\Router\Router($_GET['url']);


#Toujours mettre les routes les plus précises en premier
$router->get('/', function(){echo 'Vous êtes à la racine';});
$router->get('/home', "Home#show");#Pour appeler le controller HomeController et appeler la méthode show
$router->get('/profil', function(){echo "Ici les listes des profils";});
$router->get('/profil/:id', "Profil#show");
$router->get('/posts/:id', function ($id){echo 'article '.$id;});
$router->run();
