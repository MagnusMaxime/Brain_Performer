<?php


namespace App\Controller;


class IncidentController extends Controller
{
    static public function show()
    {
        global $twig;
        return $twig->render('incident.html', []);
    }

}
