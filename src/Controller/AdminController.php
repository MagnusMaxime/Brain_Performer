<?php


namespace App\Controller;
use App\Model\Token;
use App\Model\User;

class AdminController extends Controller {

    static public function index() {
			global $twig;
			if (self::needToBeAdmin()) {
				return "";
			}
			return $twig->render('admin/index.html', []);
    }

    static public function manageTokens($alert=""){
        global $twig;
        if (self::needToBeAdmin()) {
            return "";
        }
        $twig_array=["title"=>"Gérer les jetons", "alert"=>$alert];
        $data=Token::getAllToken();
        $twig_array["faq"]=$data;

        return $twig->render('admin/manageTokens.html', $twig_array);
    }
    static public function postTokens(){
        global $twig;
        if (self::needToBeAdmin()){//c'est pas un admin
            return "";
        }
        if (isset($_POST["q_add"])){ //l'admin veut ajouter une question
            $alert="";
            if (Token::isDoctorToken($_POST["q_add"])){
                //C'est un médecin
                $alert="Ce jeton existe déjà pour un médecin";
            }else{
                $doctor=Token::isPatientToken($_POST["q_add"]);
                if ($doctor){
                    //Inscription d'un patient qui a pour médecin $doctor
                    $alert="Ce jeton exsite déjà pour un patient";
                }else{
                    //le token ne correspond ni à un médecin ni à un patient
                    $alert="";
                    $sucess=Token::addToken($_POST["q_add"]);
                }
            }
            return self::manageTokens($alert);
        }
        //l'admin veut modifier les questions existantes
        $sucess = true;
        foreach ($_POST as $key => $value){
            if ($key[0]!="r"){
                continue;
            }
            $id=substr($key, 1);//on retire le "r" pour avoir l'id de la question pour MySQL

            if ($_POST["r".$id]=="yes"){//la question doit être retirée
                $sucess = $sucess and Token::destroyDoctorToken($id);

            }
            //$sucess = $sucess and Faq::modifyFaq($id, $_POST["q".$id], $_POST["a".$id]);
        }
        return self::manageTokens();

    }


}


class AdminUserController extends Controller
{
		static public function users() {
			global $twig;
			if (self::needToBeAdmin()) {
				return "";
			}
			$users_info = User::get_all_info();
			/* var_dump($users_info); */
			return $twig->render('admin/users.html', ["users" => $users_info]);
		}

		/**
		 * Update a user.
		 */
		static public function update($id) {
			/* $_POST['id'] */
			global $twig;
			if (self::needToBeAdmin()) {
				return "";
			}
		}

		static public function user($id) {
			global $twig;
			if (self::needToBeAdmin()) {
				return "";
			}
			return $twig->render('admin/user.html');
		}

		/* static public function userNew() { */
		/* 	global $twig; */
		/* 	if (self::needToBeAdmin()) { */
		/* 		return ""; */
		/* 	} */
		/* 	return $twig->render('adminUserNew.html') */
		/* } */

		/* static public function userUpdate() { */
		/* 	global $twig; */
		/* 	if (self::needToBeAdmin()) { */
		/* 		return ""; */
		/* 	} */
		/* 	return $twig->render('adminUserNew.html') */
		/* } */

		/* static public function userDelete() { */
		/* 	global $twig; */
		/* 	if (self::needToBeAdmin()) { */
		/* 		return ""; */
		/* 	} */
		/* 	return $twig->render('adminUserNew.html') */
		/* } */
}

