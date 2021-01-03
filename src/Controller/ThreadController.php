<?php


namespace App\Controller;

use App\Model\ThreadMessage;
use App\Model\ThreadSubject;


class ThreadController extends Controller {

	/* Sujet */

	/*
	 * Ajoute un sujet.
	 */
	static public function add_subject() {
		$user_id = $_SESSION["id"];
		ThreadMessage::add($user_id, $_POST["title"], $_POST["description"]);
	}


	/*
	 * Supprime un sujet.
	 */
	static public function delete_subject() {

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
