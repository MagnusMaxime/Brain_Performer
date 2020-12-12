<?php



namespace App;

use PDO;

define('DB_NAME', 'freedbtech_brainperformer');
define('DB_USER', 'freedbtech_brainperformer');
define('DB_PASSWORD', "uKTCaSPWVi");//'5fcWqsJurHN5qhr');
define('DB_HOST', 'freedb.tech');//Port : 3306


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


/* echo __DIR__ . "/views"; */
/* require_once('./config.php'); */
require_once  ('./model/User.php');
require_once('./Router/Router.php');
require_once('./Controller/Controller.php');
require_once ('./Controller/HomeController.php');
require_once ('./Controller/ProfileController.php');
require_once ('./Controller/TestController.php');
require_once ('./Controller/ConnectionController.php');
require_once ('./Controller/RegisterController.php');
require_once ('./Controller/ContactController.php');
require_once ('./Controller/ExerciseController.php');

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . "/views");
$twig = new \Twig\Environment($loader, []);
$DB = null;
/* try */
/* { */
/*     // On se connecte à MySQL */
/*     $bdd = new \PDO('mysql:host=localhost;dbname=brainperformer.db;charset=utf8', 'root', ''); */
/* } */
/* catch(\Exception $e) */
/* { */
/*     // En cas d'erreur, on affiche un message et on arrête tout */
/*     die('Impossible de se connnecter à la base de donnée.'.$e->getMessage()); */
/* } */

/* $reponse = $bdd->query('SELECT * FROM jeux_video'); */
/* echo $reponse; */

/* \Twig\Loader\FilesystemLoader(__DIR__ . "/views"); */


/* class Config { */
/*     static $loader = loader; */
/*     static $twig = $twig; */
/* } */

if (isset($_GET["url"])){
    $url = $_GET["url"];
}else {
    $url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
}


try {
    $DB = new PDO('mysql:host='.DB_HOST.';port=3306;dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASSWORD);
} catch (Exception $e){
    die('Erreur : ' . $e->getMessage());
}



$router =  new \App\Router\Router($url);

#Toujours mettre les routes les plus précises en premier
#$router->get('/test/:id', "Test#test");

/*function() use ($twig) {
         return $twig->render("connection.html");
});*/

$router->get('/', "Home#index");
/* $router->get('/inscription', function() use ($twig) { */
/*      echo $twig->render("signup.html", ["title"=>"Inscription"]); */
/*  }); */
$router->get('/faq', function() use ($twig) {
    echo $twig->render("faq.html", ["title"=>"FAQ"]);
});

$router->get("/connexion", "Connection#show");

$router->get("/exercices", "Exercise#showExercises");
$router->get("/contact", "Contact#show");
$router->get("/inscription", "Register#show");
$router->post("/inscription", "Register#register");

$router->get('/home', "Home#show"); #Pour appeler le controller HomeController et appeler la méthode show
$router->get('/profile', "Profile#index");
/* $router->get('/profile'); */
$router->get('/profile/:id', "Profile#render");
$router->get('/posts/:id', function ($id){echo 'article '.$id;});

echo $router->run();

