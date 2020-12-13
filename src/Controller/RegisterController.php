<?php


namespace App\Controller;


use App\Model\User;

class RegisterController extends Controller
{
    static public function get(){
        global $twig;
        return $twig->render('register.html', ["title"=>"Inscription"]);
    }

    static public function post() {//fonction appelée un fois que l'utilisateur à remplit le formulaire
        global $twig;

        if ($_POST["password"]!==$_POST["password-repeat"]){
					return $twig->render('register.html',
						["title"=>"Inscription pas ok", "alert"=>"Les mots de passe doivent correspondre."]);
        }

				if (User::does_exist(["mail" => $_POST["email"]])) {
					return $twig->render('register.html',
						["title"=>"Inscription pas ok", "alert"=>"Ce mail est déjà utilisé."]);
				}

        $user = User::register($_POST);
				header("Location: /profil/" . $user->$id);
	}
}

// Trucs d'Alexandre
        //$_POST=[["first-name"]=> string(2) "ze" ["last-name"]=> string(2) "ze" ["url-avatar"]=> string(0) "" ["gender"]=> string(3) "man" ["birthday"]=> string(10) "2020-12-22" ["email"]=> string(2) "ze" ["password"]=> string(15) "AGsJyF4t6vX7QNX" ["password-repeat"]=> string(15) "AGsJyF4t6vX7QNX" ["bp-key"]=> string(2) "ze" ["rememberme"]=> string(2) "on" }

        //var_dump($_POST);
