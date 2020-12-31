<?php


namespace App\Controller;
use App\Model\User;

class AdminController extends Controller {

    static public function index() {
			global $twig;
			if (self::needToBeAdmin()) {
				return "";
			}
			return $twig->render('admin/index.html', []);
    }

		/*
		 * Affiche tout les tokens.
		 */
		static public function token_index() {
			/* $context = Token */

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

