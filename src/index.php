<?php
namespace App;
$PATH_TEMPLATES = __DIR__ . "/views";
$PATH_CACHE = __DIR__ . "/cache";


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
require_once('./Router/Router.php');
require_once('./Controller/Controller.php');
require_once ('./Controller/HomeController.php');
require_once ('./Controller/ProfileController.php');
require_once ('./Controller/TestController.php');

/* Documentation de Twig: https://twig.symfony.com/doc/3.x/intro.html */
$loader = new \Twig\Loader\FilesystemLoader($PATH_TEMPLATES);
$twig = new \Twig\Environment($loader, [
    /* 'cache' => $PATH_CACHE, */ # À utiliser uniquement en production (ajouter var env)
]);

#Router de Graphikart : https://www.youtube.com/watch?v=I-DN2C7Gs7A
$url = isset($_GET['url']) ? $_GET['url'] : "";

$router =  new \App\Router\Router($url);

#Toujours mettre les routes les plus précises en premier
$router->get('/test/:id', "Test#test");
$router->get('/', function() use ($twig) {
    echo $twig->render("index.html", array("nom"=>"Ferdinand Bardamu", "titre"=>"Titre de la page"));
});
/* $router->get('/', "Home#index"); */
$router->get('/home', "Home#show"); #Pour appeler le controller HomeController et appeler la méthode show
$router->get('/profile', "Profile#index");
/* $router->get('/profile'); */
$router->get('/profile/:id', "Profile#render");
$router->get('/posts/:id', function ($id){echo 'article '.$id;});
echo $router->run();
