<?php
namespace App\Controller;


class FaqController extends Controller
{
    static public function show(){
        global $twig;
        $data = Faq::getFaq();
        return $twig->render('faq.html', ["title"=>"FAQ"]);
    }

}

