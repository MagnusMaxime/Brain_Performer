<?php


namespace App\Controller;


class ContactController extends Controller
{
    static public function show(){
        global $twig;
        return $twig->render('contact.html', []);
    }

}
