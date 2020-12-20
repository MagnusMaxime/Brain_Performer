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




class RegisterController extends Controller
{
	static public function get(){
		global $twig;
		return $twig->render('register.html', ["title"=>"Inscription"]);
	}

	static public function post() {//fonction appelée un fois que l'utilisateur à remplit le formulaire
		global $twig;

		$twig_array=$_POST;
		$twig_array["title"]="Inscription";

        if (!Controller::checkRecaptcha($_POST["g-recaptcha-response"])){
            //Le Recaptcha n'a pas été validé, c'est un bot
            $twig_array["alert"]="Le reCAPTACHA n'a pas été validé.";
            return $twig->render('register.html', $twig_array);
        }

        if ($_POST["password"]!==$_POST["password-repeat"]){
            $twig_array["alert"]="Les mots de passe doivent correspondre.";
			return $twig->render('register.html',$twig_array);
		}

		if (User::does_exist(["mail" => $_POST["mail"]])) {
		    $twig_array["alert"]="Ce mail est déjà utilisé.";
			return $twig->render('register.html',$twig_array);
		}

		if (!self::isAGoodPassword($_POST["password"])){
            $twig_array["alert"]="Votre mot de passe doit contenir au moins 5 caractères dont une minuscule, une majuscule et un nombre.";
            return $twig->render('register.html',$twig_array);
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
                $twig_array["alert"]="Votre token n'est pas valide";
                return $twig->render('register.html',$twig_array);
            }
        }

		$tokenEntered=$_POST["token"];

        $_POST["grade"]=$grade;//todo pas beau
        $_POST["parent"]=$parent;
        $_POST["token"]=$token;//on écrase le token du formulaire


		$user = User::register($_POST);
		if (!$user){
		//il y a eu un problème dans l'inscripition
            $twig_array["alert"]="Erreur inconnue.";
            return $twig->render('register.html',$twig_array);
		}
		/* return $twig->render("message.html", ["message"=>"vous êtes inscrit et votre id est ".$user->id]); */

        header("Location: /profil/".$user->get_id());
	}
}
