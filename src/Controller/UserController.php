<?php

namespace App\Controller;

use App\Model\User;

class UserController extends Controller
{
    /* protected $viewPath; */

    /* public function __construct() { */
        /* $this->viewPath = ROOT . '/Views/'; */
    /* } */

    public function publicDisplay($id){
            //On affiche les donneés public du profil d'id $id
            global $twig;

			if (!User::does_exist(["id" => $id])) {
				http_response_code(404);
				return $twig->render("message.html", ["message"=>"Le profil ".$id." n'existe pas :("]);
				throw new \Exception("This user does not exist!");
			} else {
				http_response_code(200);
			}
			if (isset($_SESSION["id"])){
			    //l'utilisateur est conecté
                if ($_SESSION['id']==$id){
                    //l'utilisateur regarde son propre profil, on redirige vers /moncompte
                    header("Location: /moncompte");
                    return true;
                }

            }

			$user = new User($id);
			global $twig;
			$twig_array=$user->get_info();
			$twig_array["USER"]=isset($_SESSION['user']) ? $_SESSION['user'] : false;
			var_dump(isset($_SESSION['user']) ? $_SESSION['user'] : false);
			return $twig->render('user.html', $twig_array);
    }

    public function privateDisplay(){
        //l'utilisateur est connecté et regarde son propre compte
        global $twig;
        if (self::needToBeConnected()){
            //l'utilisateur est pas connecté et a besoin d'être connecté
            return "";
        } else{
            //echo 'vous êtes co '+$_SESSION["id"];
        }

        $twig_array=["title"=>"Mon compte", "USER"=>isset($_SESSION['user']) ? $_SESSION['user'] : false];
        $twig_array["USER"]=isset($_SESSION['user']) ? $_SESSION['user'] : false;
       
        return $twig->render('myAccount.html', $twig_array);
    }

    /* public function render($id) { */
    /*     /1* ob_start(); *1/ */
    /*     /1* extract($variables); *1/ */
    /*     /1* require($this->viewPath . $view); *1/ */
    /*     /1* $content = ob_get_clean(); *1/ */
    /*     /1* /2* require($this->viewPath . 'templates/' . $this->template . '.php'); *2/ *1/ */
    /*     /1* ob_end_clean(); *1/ */
    /*     /1* echo $content; *1/ */
    /*     /1* echo 'vive le render'; *1/ */
    /*     echo $twig->render('profile.php', compact($id)); */
    /* } */
}
