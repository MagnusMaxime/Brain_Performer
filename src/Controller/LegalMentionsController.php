<?php

namespace App\Controller;


class LegalMentionsController extends Controller
{
    static public function show(){
        global $twig;
        return $twig->render('legal_mentions.html', ['title'=>"Mentions Légales", "mail"=>CONTACT_MAIL]);
    }

}

