<?php


namespace App\Controller;


class ConnectionController extends Controller
{
    static public function show(){
        global $twig;
        return $twig->render('connection.html', []);
    }

}
