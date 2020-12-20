<?php


namespace App\Controller;


class DeconnectionController extends Controller
{
    static public function show(){
        //Page qui deconnecte l'utilsateur
        global $twig;
        $_SESSION = [];
        session_destroy();
        header("Location: /");//on redirege vers la page d'accueil
        return "";

    }

}
