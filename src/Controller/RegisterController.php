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

        if (!Controller::checkRecaptcha($_POST["g-recaptcha-response"])){
            //Le Recaptcha n'a pas été validé, c'est un bot
            return $twig->render('register.html',
                ["title"=>"Inscription pas ok", "alert"=>"Le reCAPTACHA n'a pas été validé"]);
        }

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
		/* return $twig->render("message.html", ["message"=>"vous êtes inscrit et votre id est ".$user->id]); */
	header("Location: /profil/".$user->get_id());
	}
}
