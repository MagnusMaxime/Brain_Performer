<?php

namespace App\Controller;


class DoctorController extends Controller
{
    static public function show(){
        global $twig;
        return $twig->render('legal_mentions.html', ["mail"=>CONTACT_MAIL]);
    }

    static public function sendToken(){
        global $twig;
        if (self::needToBeDoctor()){
            return "";
        }
        //if (!isset($_POST[""])){}
        return $twig->render('doctor/sendToken.html', ["title"=>"Envoyer un lien"]);


    }
}

