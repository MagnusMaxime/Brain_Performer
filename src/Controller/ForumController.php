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
			if (!self::needToBeConnected()) {
				/* header("Location: /connexion"); */
				return "";
			}
			$subjects_number = 20;
			$context = ["subjects" => []];
			$subjects = ForumSubject::select_recent($subjects_number);
			foreach ($subjects as $subject) {
				$context["subjects"][] = $subject->info();
			}
			return $twig->render('forum.html', $context);
	}


	/*
	 * Permet d'afficher des messages pour un sujet du forum.
	 */
	static public function subject($title) {
			global $twig;
			if (!self::needToBeConnected()) {
				/* header("Location: /connexion"); */
				return "";
			}
			$context = [];
			$subject = ForumSubject::from_title($title);
			$context["subject"] = $subject->info();
			$context["messages"] = [];
			$messages = ForumMessage::all(["subject" => $subject->id]);
			var_dump($messages);
			foreach ($messages as $key => $message) {
				$context["messages"][] = $message->info();
			}
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
	 * Ajoute un message.
	 */
	static public function add_message($title) {
		$user_id = $_SESSION["id"];
		$subject = ForumSubject::from_title($title);
		$subject_id = $subject->id;
		ForumMessage::add($user_id, $_POST["message"], $subject_id);
		$title = urlencode($title);
		header("Location: /forum/".$title);
	}

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
