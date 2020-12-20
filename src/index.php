<?php



namespace App;

use PDO;

define("RECAPTCHA_SECRET_KEY", "6LfaqQcaAAAAACjDJ6ioUZ9aBQnPKVSLD7UXnv-e");
define('DB_NAME', 'freedbtech_brainperformer');
define('DB_USER', 'freedbtech_brainperformer');
define('DB_PASSWORD', "uKTCaSPWVi");//'5fcWqsJurHN5qhr');
define('DB_HOST', 'freedb.tech');//Port : 3306

define("MAIL",'contact.brainperformer@gmail.com');
define('MAIL_PASSWORD', 'brainperformer');

define("CONTACT_MAIL", "contact.brainperformer@gmail.com");//mail de contact pour brainperformer

require_once('../vendor/autoload.php');

/* function log($variable) { */
/* 	error_log(print_r($variable, TRUE)); */
/* } */


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
require_once ('./model/Faq.php');
require_once ('./model/Ticket.php');
require_once ("./model/Token.php");
require_once('./Router/Router.php');
require_once('./Controller/Controller.php');
require_once ('./Controller/HomeController.php');
require_once ('./Controller/UserController.php');
require_once ('./Controller/TestController.php');
require_once ('./Controller/ConnectionController.php');
require_once ('./Controller/RegisterController.php');
require_once ('./Controller/ContactController.php');
require_once ('./Controller/ExerciseController.php');
require_once('./Controller/LegalMentionsController.php');
require_once('./Controller/IncidentController.php');
require_once ("./Controller/FaqController.php");
require_once ("./Controller/DeconnectionController.php");
require_once ("./Controller/DashboardController.php");
require_once ("./Controller/AdminController.php");

session_start();
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . "/views");
$twig = new \Twig\Environment($loader, []);
$USER = isset($_SESSION['user']) ? $_SESSION['user'] : false;
$twig->addGlobal('USER', $USER);

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
} catch (\Exception $e){
    die('Erreur : ' . $e->getMessage());
}

$router =  new \App\Router\Router($url);

#Toujours mettre les routes les plus précises en premier
#$router->get('/test/:id', "Test#test");

/*function() use ($twig) {
         return $twig->render("connection.html");
});*/

$router->get('/', "Home#index");
$router->get('/cgu', function() use ($twig) {
     echo $twig->render("CGU.html", ["title"=>"CGU"]);
});

$router->get("/faq", "Faq#show");
$router->get("/connexion", "Connection#get");
$router->post("/connexion", "Connection#post");
$router->get("/deconnexion", "Deconnection#show");
$router->get("/exercices", "Exercise#show");
$router->get("/contact", "Contact#show");
$router->post("/contact", "Contact#post");
$router->get("/inscription", "Register#get");
$router->post("/inscription", "Register#post");

$router->get('/home', "Home#show"); #Pour appeler le controller HomeController et appeler la méthode show

$router->get('/profil/:id', "User#publicDisplay");
$router->get('/moncompte', "User#privateDisplay");
$router->get("/modifierprofil/:id", "User#displayEditPage");
$router->post("/modifierprofil/:id", "User#modifyAccount");

$router->get("/mentions-legales", "LegalMentions#show");
$router->get("/incident", "Incident#show");

# Dev
$router->get('/reglage', "Dashboard#show");
$router->get('/gerer-faq', "Faq#manage");
$router->post('/gerer-faq', "Faq#post");

# Admin
$router->get('/admin', "Admin#index");
$router->get('/admin/user/:id', "Admin#user");
$router->post('/admin/user/:id', "Admin#user");
$router->get('/admin/users', "Admin#users");
//$router->get('/posts/:id', function ($id){echo 'article '.$id;});



echo $router->run();

