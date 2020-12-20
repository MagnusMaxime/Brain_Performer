<?php


namespace App\Controller;


class AdminController extends Controller
{
    static public function index() {
			global $twig;
			if (self::needToBeAdmin()) {
				return "";
			}
			return $twig->render('admin.html', []);
    }

		static public function users() {
			global $twig;
			if (self::needToBeAdmin()) {
				return "";
			}
			return $twig->render('adminUsers.html')
		}

		static public function user() {
			global $twig;
			if (self::needToBeAdmin()) {
				return "";
			}
			return $twig->render('adminUser.html')
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
