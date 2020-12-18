<?php

namespace App\Controller;


class LegalMentionsController extends Controller
{
    static public function show(){
        global $twig;
        return $twig->render('legal_mentions.html', ["mail"=>CONTACT_MAIL]);
    }

}

