<?php


namespace App\Controller;


class TicketController extends Controller
{
	/*
	 * Permet d'afficher la liste des tickets.
	 */
    static public function index() {
        global $twig;
        return $twig->render('ticket-index.html', []);
    }

		/*
		 * Permet d'afficher un ticket particulier,
		 * ainsi que les réponses d'un administrateur à
		 * celui-ci.
		 */
		static public function render($id) {
			global $twig;
			return $twig->render('ticket-render.html', []);
		}
}

