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

		if (User::does_exist(["mail" => $_POST["mail"]])) {
			return $twig->render('register.html',
				["title"=>"Inscription pas ok", "alert"=>"Ce mail est déjà utilisé."]);
		}

		$user = User::register($_POST);
		if (!$user){
		    //il y a eu un problème dans l'inscripition
            return $twig->render('register.html',
                ["title"=>"Inscription pas ok", "alert"=>"Erreur inconnue"]);
        }
		//echo $user->$id;
		//header("Location: /profil/".$user->$id);
        return $twig->render("message.html", ["message"=>"vous êtes inscrit et votre id est ".$user->id]);
	}
}
