<?php

namespace App\Controller;

class HomeController extends Controller
{
    static public function index(){
        global $twig;
        return $twig->render('index.html', []);
    }
    public function show(){
        return "Je suis la home page";
    }
}
