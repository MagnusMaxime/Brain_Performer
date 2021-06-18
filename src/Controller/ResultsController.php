<?php


namespace App\Controller;

class ResultsController extends Controller
{
    static public function show(){
        global $twig;
        return $twig->render('results.html');
    }
}

