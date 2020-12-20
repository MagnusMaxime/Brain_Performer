<?php


namespace App\Controller;


use App\Model\User;

class ConnectionController extends Controller
{
    static public function get() {
        global $twig;
        return $twig->render('connection.html', ["title"=>"Connexion"]);
    }
    static public function post() {
        global $twig;
        /* var_dump($_POST); */
				if (!User::does_exist(["mail" => $_POST["mail"]])) {
                return $twig->render('connection.html', ["title"=>"Connexion", "alert"=>"Cet email n'est pas reconnu."]);
				}

				if (!User::match_password($_POST["mail"], $_POST["password"])) {
            return $twig->render('connection.html', ["title"=>"Connexion", "alert"=>"Mot de passe invalide."]);
				}

        $user = User::connect($_POST["mail"], $_POST["password"]);

				header("Location: profil/" . strval($user->get_id()));

        /* if ($success){ */
        /*     return $twig->render('message.html', ["title"=>"Profil", "message"=>"Vous êtes connecté, bravo !"]); */
        /* }else{ */
        /*     return $twig->render('connection.html', ["title"=>"Connexion", "alert_message"=>"Echec de l'authentification"]); */
        /* } */

    }

    static public function forgottenPassword(){
        global $twig;
        return $twig->render('forgottenPassword.html', ["title"=>"Mot de passe oublié"]);
    }

}
