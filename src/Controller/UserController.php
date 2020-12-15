<?php

namespace App\Controller;

use App\Model\User;

class UserController extends Controller
{
    /* protected $viewPath; */

    /* public function __construct() { */
        /* $this->viewPath = ROOT . '/Views/'; */
    /* } */

    public function index($id){
			/* return "Je présente le profil ".$id; */
			if (!User::does_exist(["id" => $id])) {
				http_response_code(404);
				throw new \Exception("This user does not exist!");
			} else {
				http_response_code(200);
			}
			$user = new User($id);
			global $twig;
			return $twig->render('user.html', $user->get_info());
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
