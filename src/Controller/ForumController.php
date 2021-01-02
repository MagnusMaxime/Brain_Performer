<?php


namespace App\Controller;

use App\Model\ForumSubject;
use App\Model\ForumMessage;


class ForumController extends Controller
{
    static public function index()
    {
        global $twig;
				$subjects_number = 20;
				$context = ForumSubject::get_context($subjects_number);
        return $twig->render('forum.html', $context);
    }

    static public function subject($title)
    {
        global $twig;
				$context = ForumMessage::get_context();
        return $twig->render('forum-subject.html', $context);
    }

}
