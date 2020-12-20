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
}


class AdminUserController extends Controller
{
		static public function users() {
			global $twig;
			if (self::needToBeAdmin()) {
				return "";
			}
			$users_array = User::get_all();
			var_dump($users_array);
			return $twig->render('admin/users.html', ["users" => $users_array]);
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

