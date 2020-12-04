<?php


namespace App\Controller;


class RegisterController extends Controller
{
    static public function show(){
        global $twig;
        return $twig->render('register.html', []);
    }

}

