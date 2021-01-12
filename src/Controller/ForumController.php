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
			if (self::needToBeConnected()) {
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
			if (self::needToBeConnected()) {
				return "";
			}
			$context = [];
			$title = urldecode($title);
			$subject = ForumSubject::from_title($title);
			$context["subject"] = $subject->info();
			$context["messages"] = [];
			$context["user"] = $_SESSION["user"];
			$limit = 10;
			$messages = ForumMessage::select($subject->id, $limit);
			foreach ($messages as $message) {
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
	 * Charge plus de messages sur la page.
	 * Renvoie ces messages sous forme de fichier json.
	 */
	static public function load_messages($title, $limit, $offset) {
		$title = urldecode($title);
		$subject = ForumSubject::from_title($title);
		error_log($title." (".strval($subject->id)."): ".$offset." - ".$limit);
		$messages = ForumMessage::select($subject->id, $limit, $offset);
		$data = [];
		foreach ($messages as $message) {
			$data[] = $message->info();
			}
		$payload = json_encode($data, JSON_FORCE_OBJECT);
		error_log($payload);
		/* var_dump($payload); */
		return $payload;
	}

	/*
	 * Ajoute un message.
	 */
	static public function add_message($title) {
		$user_id = $_SESSION["id"];
		$title = urldecode($title);
		$subject = ForumSubject::from_title($title);
		$subject_id = $subject->id;
		$message = ForumMessage::add($user_id, $_POST["message"], $subject_id);
		/* var_dump($message); */
		$title = urlencode($title);
		header("Location: /forum/".$title.'/#'.$message->id);
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
