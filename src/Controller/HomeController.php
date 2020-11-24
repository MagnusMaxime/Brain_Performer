<?php

namespace App\Controller;

class HomeController extends Controller
{
    static public function index(){
        return $twig->render('index.html', []);
    }
    public function show(){
        echo "Je suis la home page";
    }
}
