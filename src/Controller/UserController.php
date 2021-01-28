<?php

namespace App\Controller;

use App\Model\User;


function canEditProfil($id){
    //retourne si l'utilsateur connecté peut editer le profil
    return $_SESSION["grade"]>=2  or $_SESSION["id"]==$id;
}

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


			$user = new User($id);
			$user_info = $user->get_info();
			if (intval($user_info["public"])==0){
			    //l'utilisateur que l'on veut afficher est privé
							if ($_SESSION["grade"]==0){
									//un patient veut voir un compte privé qui n'est pas à lui
									header("Location: /");
									return "";
							}
							if ($_SESSION["grade"]==1){
									//le médecin peut voir le profil uniquement si c'est son patient
									if ($_SESSION["id"]==$user_info["parent"]){
											//C'est ok

									}else{
											//ce n'est pas le médecin du patient
											header("Location: /");
											return "";
									}
							}
					}

			global $twig;
			$user_info=$user->get_info();
			$twig_array = $user_info;
			$twig_array["USERI"]=$user_info; //isset($_SESSION['user']) ? $_SESSION['user'] : false;
			//var_dump(isset($_SESSION['user']) ? $_SESSION['user'] : false);
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
        $user = new User($_SESSION["id"]);
        $user_info=$user->get_info();
        $twig_array = $user_info;
        $twig_array["title"]="Mon compte";
        //$twig_array["USER"]=isset($_SESSION['user']) ? $_SESSION['user'] : false;
        $twig_array["USER"]=$user_info;
        return $twig->render('myAccount.html', $twig_array);
    }

    public function displayEditPage ($id){
        //affiche la page pour modifier le compte d'id $id
        global $twig;

        if (self::needToBeConnected()){
            //l'utilisateur est pas connecté et a besoin d'être connecté
            return "";
        }
        if (!canEditProfil($id)){
            //l'utilisateur est pas un admin et essaye de modifier un compte qui n'est pas à lui
            header("Location: /");
            return "";
        }
        $user = new User($id);
        $twig_array=$user->get_info();
        $twig_array["title"]="Modifier le profil";
        return $twig->render('editAccount.html', $twig_array);

    }

    public function modifyAccount($id){
        global $twig;
        if (self::needToBeConnected()){
            //l'utilisateur est pas connecté et a besoin d'être connecté
            return "";
        }
        if (!canEditProfil($id)){
            //l'utilisateur est pas un admin et essaye de modifier un compte qui n'est pas à lui
            header("Location: /");
            return "";
        }
        $user = new User($id);
        $twig_array=$user->get_info();
        $twig_array["title"]="Modifier le profil";

        if (User::does_exist(["mail" => $_POST["mail"]]) and $_SESSION["mail"]!=$_POST["mail"]) {
            //l'utilisateur a modifié son mail mais ce dernier est utilisé par un autre compte
            $twig_array["alert"]="Ce mail est déjà utilisé.";
            return $twig->render('editAccount.html', $twig_array);
        }

        if ($_POST["password"]==""){
            //l'utilisateur ne compte pas modifier son mot de passe

            $_POST["password"]= $_SESSION["user"]["password"];//on remet l'ancien hash de mot de passe

        } else if ($_POST["password"]!==$_POST["password-repeat"]) {
            $twig_array["alert"]="Les mots de passe doivent correspondre.";
            return $twig->render('editAccount.html', $twig_array);

        }else if (!self::isAGoodPassword($_POST["password"])){
            $twig_array["alert"]="Votre nouveau mot de passe doit contenir au moins 5 caractères dont une minuscule, une majuscule et un nombre.";
            return $twig->render('editAccount.html', $twig_array);
        }else{
            //Tout est bon
            $_POST["password"]=password_hash($_POST["password"], PASSWORD_DEFAULT);
        }

        $success=$user->update($_POST);
        if ($success){
            header("Location: /profil/".$user->get_id());
            return "";
        }else{
            $twig_array["alert"]="Erreur inconnue.";
            return $twig->render('editAccount.html', $twig_array);
        }
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
