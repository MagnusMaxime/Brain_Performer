<?php


namespace App\Controller;
use App\Model\Ticket;


class TicketController extends Controller
{
	/*
	 * Permet d'afficher la liste des tickets.
	 */
    static public function index() {
        global $twig;
				$subjects_number = 20;
				$context = TicketSubject::get_context($subjects_number);
        return $twig->render('ticket.html', $context);
    }

		/*
		 * Permet d'afficher un ticket particulier,
		 * ainsi que les réponses d'un administrateur à
		 * celui-ci.
		 */
		static public function subject($title) {
			global $twig;
			$context = TicketMessage::get_context();
			return $twig->render('ticket-subject.html', $context);
		}
}

