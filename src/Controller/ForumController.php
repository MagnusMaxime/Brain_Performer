<?php


namespace App\Controller;

use App\Model\ForumSubject;
use App\Model\ForumMessage;


class ForumController extends ThreadController {

	/* static public function get_subject_model() { */
	/* 	return ForumSubject; */
	/* } */

	/* static public function get_message_model() { */
	/* 	return ForumMessage; */
	/* } */

	/*
	 * Permet d'afficher la liste des sujets du forum.
	 */
	static public function index() {
			global $twig;
			$subjects_number = 20;
			$context = ForumSubject::get_context($subjects_number);
			return $twig->render('forum.html', $context);
	}


	/*
	 * Permet d'afficher des messages pour un sujet du forum.
	 */
	static public function subject($title) {
			global $twig;
			$context = ForumMessage::get_context($title);
			return $twig->render('forum-subject.html', $context);
	}

	/* Sujet */

	/*
	 * Ajoute un sujet.
	 */
	static public function add_subject() {
		$user_id = $_SESSION["id"];
		ForumSubject::add($user_id, $_POST["title"], $_POST["description"]);
		$title = urlencode($_POST["title"]);
		header("Location: /forum/".$title);
	}

	/*
	 * Actualise un sujet.
	 */
	static public function update_subject() {
		$user_id = $_SESSION["id"];
		ForumSubject::update($user_id, $_POST["title"], $_POST["description"]);
		$title = urlencode($_POST["title"]);
		header("Location: /forum/".$title);
	}


	/*
	 * Supprime un sujet.
	 */
	static public function delete_subject() {
		ForumSubject::delete($_POST["title"]);
		/* $title = urlencode($_POST["title"]); */
		header("Location: /forum");
	}

	/* Message */

	/*
	 * Actualise un message.
	 */
	static public function update_message() {

	}

	/*
	 * Supprime un message.
	 */
	static public function delete_message() {

	}
}
