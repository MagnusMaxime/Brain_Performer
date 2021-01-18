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

define("URLAVATAR_MALE", "https://img.icons8.com/fluent/344/user-male.png");
define("URLAVATAR_FEMALE", "https://img.icons8.com/fluent/344/user-female.png");

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

/* Models */
require_once('./model/SQLTable.php');
require_once('./model/User.php');
require_once('./model/Faq.php');
require_once("./model/Token.php");
require_once("./model/UserListAdmin.php");
require_once('./model/Thread.php');
require_once('./model/Ticket.php');
require_once("./model/Forum.php");

/* Controllers */
require_once('./Controller/Controller.php');
require_once('./Controller/HomeController.php');
require_once('./Controller/UserController.php');
require_once('./Controller/TestController.php');
require_once('./Controller/ConnectionController.php');
require_once('./Controller/RegisterController.php');
require_once('./Controller/ContactController.php');
require_once('./Controller/ExerciseController.php');
require_once('./Controller/LegalMentionsController.php');
require_once("./Controller/FaqController.php");
require_once("./Controller/DeconnectionController.php");
require_once("./Controller/AdminController.php");
require_once("./Controller/DoctorController.php");
require_once("./Controller/UserListAdminController.php");
require_once("./Controller/SearchController.php");
require_once('./Controller/ThreadController.php');
require_once('./Controller/ForumController.php');
require_once("./Controller/TicketController.php");

require_once('./Router/Router.php');

session_start();
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . "/views");
$twig = new \Twig\Environment($loader, []);
$USER = isset($_SESSION['user']) ? $_SESSION['user'] : false;
$twig->addGlobal('USER', $USER);

$twig->addGlobal("AVATAR_FEMALE_PLACEHOLDER", URLAVATAR_FEMALE);
$twig->addGlobal("AVATAR_MALE_PLACEHOLDER", URLAVATAR_MALE);

/* echo URLAVATAR_MALE; */
/* echo URLAVATAR_FEMALE; */

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
	$DB = False;
    /* die('Erreur : ' . $e->getMessage()); */
}

$router =  new \App\Router\Router($url);

#Toujours mettre les routes les plus précises en premier
$router->get('/test', "Test#index");
$router->get('/test/alert', "Test#alert");

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
$router->get("/mot-de-passe-oublie", "Connection#forgottenPassword");
$router->get("/deconnexion", "Deconnection#show");
$router->get("/exercices", "Exercise#show");
$router->get("/contact", "Contact#show");
$router->post("/contact", "Contact#post");
$router->get("/inscription", "Register#get");
$router->post("/inscription", "Register#post");
$router->get("/mentions-legales", "LegalMentions#show");

$router->get("/forum", "Forum#index");
$router->post("/forum/sujet/ajouter", "Forum#add_subject");
$router->post("/forum/sujet/modidfier", "Forum#update_subject");
$router->post("/forum/sujet/supprimer", "Forum#delete_subject");
$router->post("/forum/:title/message/ajouter", "Forum#add_message");
$router->get("/forum/:title/message/charger/:offset/:title", "Forum#load_messages");
$router->post("/forum/message/modifier/:id", "Forum#update_message");
$router->post("/forum/message/supprimer/:id", "Forum#delete_message");
$router->get("/forum/:title","Forum#subject");

$router->get("/ticket", "Ticket#index");
$router->post("/ticket/sujet/ajouter", "Ticket#add_subject");
$router->post("/ticket/sujet/modidfier", "Ticket#update_subject");
$router->post("/ticket/sujet/supprimer", "Ticket#delete_subject");
$router->post("/ticket/:title/message/ajouter", "Ticket#add_message");
$router->get("/ticket/:title/message/charger/:offset/:title", "Ticket#load_messages");
$router->post("/ticket/message/modifier/:id", "Ticket#update_message");
$router->post("/ticket/message/supprimer/:id", "Ticket#delete_message");
$router->get("/ticket/:title","Ticket#subject");

$router->get("/rechercher", "Search#show");
$router->get('/profil/:id', "User#publicDisplay");
$router->get('/moncompte', "User#privateDisplay");
$router->get("/profil/:id/modifier", "User#displayEditPage");
$router->post("/profil/:id/modifier", "User#modifyAccount");

//pour le forum :
$router->post('/forum', "Forum#add_subject");


# Doctor
$router->get("/medecin/envoyer-un-lien", "Doctor#sendToken");
$router->post("/medecin/envoyer-un-lien", "Doctor#sendToken");
$router->get('/patients', "Doctor#patients");

# Admin
$router->get('/admin', "Admin#index");
$router->get('admin/token', "Admin#manageTokens");
$router->post('admin/token', "Admin#postTokens");
$router->get('/admin/profils', "AdminUser#users");
$router->get('/admin/profil/:id', "AdminUser#user");
$router->post('/admin/profil/:id', "AdminUser#user");
$router->get('/admin/faq', "Faq#manage");
$router->post('/admin/faq', "Faq#post");
$router->get("/admin/gestion-utilisateurs", "UserListAdmin#get");
$router->post('/admin/gestion-utilisateurs-ajouter', "UserListAdmin#postadd");
$router->post('/admin/gestion-utilisateurs-actualiser/:id', "UserListAdmin#postupdate");
$router->get('admin/gestion-utilisateurs/supprimer/:id', "UserListAdmin#delete");

# API
$router->get("/api/search", "Search#api");
$router->get("/api/token", "Register#apiToken");

echo $router->run();
