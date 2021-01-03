<?php


namespace App\Controller;

use App\Model\ForumSubject;
use App\Model\ForumMessage;


class ForumController extends Controller
{
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
}
