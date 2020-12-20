<?php


namespace App\Controller;

use App\Model\Token;
use App\Model\User;


function randomPassword($len) {
    $alphabet = 'abcdefghijklmnopqrstuvwxyz1234567890';
    $pass = "";
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < $len; $i++) {
        $n = rand(0, $alphaLength);
        $pass .= $alphabet[$n];
    }
    return $pass;
}

function getNewTokenForDoctor($len){
    $token=randomPassword($len);
    while (Token::isPatientToken($token) or Token::isDoctorToken($token)){
        $token=randomPassword($len);
    }
    return $token;

}


function isAGoodPassword($pass){
    if(preg_match('/[A-Z]/', $pass)){
        // Il y a une majuscule dans le mot de passe
        if(preg_match('/[a-z]/', $pass)){
            // Il y a une minuscule dans le mot de passe
            if(preg_match('/[0-9]/', $pass)){
                // Il y a un nombre dans le mot de passe
                return strlen($pass)>=5;//il faut au moins 5 caractère dans le mot de passe
            }
        }
    }
    return false;
}


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
                ["title"=>"Inscription", "alert"=>"Le reCAPTACHA n'a pas été validé."]);
        }

        if ($_POST["password"]!==$_POST["password-repeat"]){
			return $twig->render('register.html',
				["title"=>"Inscription", "alert"=>"Les mots de passe doivent correspondre."]);
		}

		if (User::does_exist(["mail" => $_POST["mail"]])) {
			return $twig->render('register.html',
				["title"=>"Inscription", "alert"=>"Ce mail est déjà utilisé."]);
		}
		if (!isAGoodPassword($_POST["password"])){
            return $twig->render('register.html',
                ["title"=>"Inscription", "alert"=>"Votre mot de passe doit contenir au moins 5 caractères dont une minuscule, une majuscule et un nombre."]);
        }

        $grade=-1;
		$parent=0;
		$token='';

		if (Token::isDoctorToken($_POST["token"])){
		    //C'est un médecin
            $grade=array_search("médecin", User::$grades);
            Token::destroyDoctorToken($_POST["token"]);//on détruit le token des token disponible pour des inscription médecin
            //$token = getNewTokenForDoctor(10); //on génére un token pour les futurs patients du médecin
            $token = $_POST["token"];//Le token associé au médecin est celui du formulaire
            if ($grade===false){
                throw new \Exception("Il n'y a pas 'médecin' dans les grades :(");
            }
        }else{
		    $doctor=Token::isPatientToken($_POST["token"]);
		    if ($doctor){
		        //Inscription d'un patient qui a pour médecin $doctor
                $grade=array_search("patient", User::$grades);
                $parent=$doctor->id;
                if ($grade===false){//NE PAS CHANGER EN !$grade
                    throw new \Exception("Il n'y a pas 'patient' dans les grades :(");
                }
            }else{
		        //le token ne correspond ni à un médecin ni à un patient
                return $twig->render('register.html',
                    ["title"=>"Inscription", "alert"=>"Votre token n'est pas valide"]);
            }
        }

		$tokenEntered=$_POST["token"];

        $_POST["grade"]=$grade;//todo pas beau
        $_POST["parent"]=$parent;
        $_POST["token"]=$token;//on écrase le token du formulaire


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
