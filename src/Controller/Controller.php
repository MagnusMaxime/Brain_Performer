<?php

namespace App\Controller;

/* echo __DIR__; */

/* echo PATH_TEMPLATES; */
/* echo FilesystemLoader; */
/* echo $$GLOBALS['twig']; */

class Controller
{

	static public function getUrl() {
			if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
				 $url = "https://";
			else
				 $url = "http://";

			// Append the host(domain name, ip) to the URL.
			$url.= $_SERVER['HTTP_HOST'];

			// Append the requested resource location to the URL
			$url.= $_SERVER['REQUEST_URI'];
			return $url;
	}
    /* protected $twig = $$GLOBALS['twig']; */
    /* global $twig; */
    /* static $twig = $GLOBALS["twig"]; */
    static public function checkRecaptcha($captcha){
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret='.urlencode(RECAPTCHA_SECRET_KEY).'&response=' . urlencode($captcha);
        $response = file_get_contents($url);
        $responseKeys = json_decode($response, true);
        // should return JSON with success as true
        return $responseKeys["success"];
    }

    static public function needToBeConnected(){
        //Retourne true s'il l'utilisateur n'est pas connecté, false sinon
        if (!isset($_SESSION['id'])){//on regarde si l'utilisateur n'est pas connecté
            //l'utilisateur essaye d'accéder à une page qui demande d'être connecté mais l'utilisateur n'est pas connecté
						$_SESSION['next'] = self::getUrl();
            header("Location: /connexion");
            return true;
        }
        return false;
    }

    static public function needToBeDev() {
        if (self::needToBeConnected()) {
            return true;
        }
        if ($_SESSION["grade"]<=2) {
            header("Location: /");
            return true;
        }
        return false;
    }

    static public function needToBeDoctor(){
        //Retourne true s'il l'utilisateur n'est pas connecté pas connecté en tant que doctor, false sinon
        if (self::needToBeConnected()) {
            return true;
        }
        if ($_SESSION["grade"]!=1) {
            header("Location: /");
            return true;
        }
        return false;
    }

    static public function needToBeAdmin(){
        if (!isset($_SESSION['id'])){//on regarde si l'utilisateur n'est pas connecté
            //l'utilisateur essaye d'accéder à une page qui demande d'être connecté mais l'utilisateur n'est pas connecté
						$_SESSION['next'] = self::getUrl();
            header("Location: /connexion");
            return true;
        } else if ($_SESSION["grade"]<=1){
            //l'utilisateur est connecté mais c'est un patient ou un médecin
            header("Location: /"); // on le redirige à l'accueil
            return true;
        }
        return false;
    }

    static public function isAGoodPassword($pass){
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
}
