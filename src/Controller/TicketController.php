<?php


namespace App\Controller;

use App\Model\TicketSubject;
use App\Model\TicketMessage;


class TicketController extends ThreadController {

	/* static public function get_subject_model() { */
	/* 	return TicketSubject; */
	/* } */

	/* static public function get_message_model() { */
	/* 	return TicketMessage; */
	/* } */

	/*
	 * Permet d'afficher la liste des sujets du ticket.
	 */
	static public function index() {
			global $twig;
			if (self::needToBeConnected()) {
				return "";
			}
			$subjects_number = 20;
			$context = ["subjects" => []];
			$subjects = TicketSubject::select_recent($subjects_number);
			foreach ($subjects as $subject) {
				$info = $subject->info();
				if ($_SESSION['grade'] >= 2 || $_SESSION['id'] == $info['user']['id'])
					$context["subjects"][] = $info;
			}
			return $twig->render('ticket.html', $context);
	}

	/*
	 * Permet d'afficher des messages pour un sujet du ticket.
	 */
	static public function subject($title) {
			global $twig;
			if (self::needToBeConnected()) {
				return "";
			}
			$context = [];
			$title = urldecode($title);
			error_log('requested: '.$title);
			try {
				$subject = TicketSubject::from_title($title);
			} catch (\Exception $e) {
				header('Location: /ticket');
			}
			$context["subject"] = $subject->info();
			if ($_SESSION['grade'] < 2) {
				error_log('grade refused: '.$_SESSION['grade']);
				error_log('subject: '.$context['subject']);
				error_log($context['subject']['user']['id']);
				if ($_SESSION['id'] != $context['subject']['user']['id']) {
					error_log('connexion refused');
					header('Location: /ticket');
				}
			} else {
				error_log('grade accepted: '.$_SESSION['grade']);
			}
			$context["messages"] = [];
			$context["user"] = $_SESSION["user"];
			$limit = 10;
			if (isset($_GET['limit']))
				if ($_GET['limit'] == 'all')
					$limit = 9999999999;
			error_log($limit);
			$messages = TicketMessage::select($subject->id, $limit);
			foreach ($messages as $message) {
				$context["messages"][] = $message->info();
			}
			return $twig->render('ticket-subject.html', $context);
	}

	/* Sujet */

	/*
	 * Ajoute un sujet.
	 */
	static public function add_subject() {
		TicketSubject::add($_SESSION["id"], $_POST["title"], $_POST["description"]);
		$subject = TicketSubject::from_title($_POST["title"]);
		TicketMessage::add($_SESSION["id"], $_POST["message"], $subject->id);
		$title = urlencode($_POST["title"]);
		header("Location: /ticket/".$title);
	}

	/*
	 * Actualise un sujet.
	 */
	static public function update_subject() {
		$user_id = $_SESSION["id"];
		TicketSubject::update($user_id, $_POST["title"], $_POST["description"]);
		$title = urlencode($_POST["title"]);
		header("Location: /ticket/".$title);
	}


	/*
	 * Supprime un sujet.
	 */
	static public function delete_subject() {
		TicketSubject::delete($_POST["title"]);
		/* $title = urlencode($_POST["title"]); */
		header("Location: /ticket");
	}

	/* Message */
	/* static public function count_messages($title) { */
	/* 	$title = urldecode($title); */
	/* 	$title = urldecode($title); */
	/* 	$subject = TicketSubject::from_title($title); */
	/* 	error_log($title." (".strval($subject->id)."): ".$offset." - ".$limit); */
	/* 	$count = TicketMessage::count($subject->id); */
	/* 	return $count; */
	/* } */

	/*
	 * Charge plus de messages sur la page.
	 * Renvoie ces messages sous forme de fichier json.
	 */
	static public function load_messages($title, $limit, $offset) {
		$title = urldecode($title);
		$subject = TicketSubject::from_title($title);
		error_log($title." (".strval($subject->id)."): ".$offset." - ".$limit);
		$messages = TicketMessage::select($subject->id, $limit, $offset);
		$count = TicketMessage::count(['subject' => $subject->id]);
		error_log('count:'. strval($count));
		/* var_dump($count); */
		$data = [];
		$data['messages'] = [];
		$data['count'] = $count;
		foreach ($messages as $message) {
			$data['messages'][] = $message->info();
			/* $data[] = $message->info(); */
		}
		$payload = json_encode($data, JSON_FORCE_OBJECT);
		/* error_log($payload); */
		/* var_dump($payload); */
		return $payload;
	}

	/*
	 * Ajoute un message.
	 */
	static public function add_message($title) {
		var_dump($_POST);
		$user_id = $_SESSION["id"];
		$title = urldecode($title);
		$subject = TicketSubject::from_title($title);
		$subject_id = $subject->id;
		$message = TicketMessage::add($user_id, $_POST["message"], $subject_id);
		header('SUCCESS');
		/* var_dump($message); */
		/* $title = urlencode($title); */
		/* header("Location: /ticket/".$title.'?limit=all#'.$message->id); */
	}

	/*
	 * Actualise un message.
	 */
	static public function update_message() {

	}

	/*
	 * Supprime un message.
	 */
	static public function delete_message($id) {
		TicketMessage::delete($id);
		header('SUCCESS');
	}
}
