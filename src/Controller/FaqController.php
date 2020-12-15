<?php
namespace App\Controller;

use App\Model\Faq;


class FaqController extends Controller
{
    static public function show(){
        global $twig;
        $data = Faq::getFaq();
        if (!$data){
            //Il y a eu un souci dans la requête de la BDD
            return $twig->render('faq.html', ["title"=>"noFAQ"]);
        }
        return $twig->render('faq.html', ["title"=>"FAQ", "faq"=>$data]);
    }

}

