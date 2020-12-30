<?php

namespace App\Controller;

class TestController extends Controller
{
    static public function index() {
			return "This is a test.";
    }
		static public function alert() {
			global $twig;
			$context = [
				"alert" => "alert",
				"primary" => "primary",
				"secondary" => "secondary",
				"success" => "success",
				"danger" => "danger",
				"warning" => "warning",
				"info" => "info",
				"light" => "light",
				"dark" => "dark"
			];
			return $twig->render('layout.html', $context);
		}
}
