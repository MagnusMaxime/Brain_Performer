<?php


namespace App\Controller;


class RegisterController extends Controller
{
    static public function show(){
        global $twig;
        return $twig->render('register.html', ["title"=>"Inscription"]);
    }

    static public function register(){//fonction appelée un fois que l'utilisateur à remplit le formulaire
        global $twig;
        //$_POST=[["first-name"]=> string(2) "ze" ["last-name"]=> string(2) "ze" ["url-avatar"]=> string(0) "" ["gender"]=> string(3) "man" ["birthday"]=> string(10) "2020-12-22" ["email"]=> string(2) "ze" ["password"]=> string(15) "AGsJyF4t6vX7QNX" ["password-repeat"]=> string(15) "AGsJyF4t6vX7QNX" ["bp-key"]=> string(2) "ze" ["rememberme"]=> string(2) "on" }

        //var_dump($_POST);

        if ($_POST["password"]!==$_POST["password-repeat"]){

            return $twig->render('register.html', ["title"=>"Inscription pas ok"]);
        }

        return $twig->render('message.html', ["title"=>"Bravo", "message"=>"Votre inscription a bien été faite"]);
    }

}

