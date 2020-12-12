<?php


namespace App\Controller;


use App\Model\User;

class ConnectionController extends Controller
{
    static public function show(){
        global $twig;
        return $twig->render('connection.html', []);
    }
    static public function connect(){
        global $twig;
        var_dump($_POST);
        $success = User::connect($_POST["mail"], $_POST["password"]);

        if ($success){
            return $twig->render('message.html', ["title"=>"Profil", "message"=>"Vous êtes connecté, bravo !"]);
        }else{
            return $twig->render('connection.html', ["title"=>"Connexion", "alert_message"=>"Echec de l'authentification"]);
        }

    }

}
