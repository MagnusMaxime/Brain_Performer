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
            return $twig->render('faq.html', ["title"=>"noFAQ", "faq"=>[["question"=>"PK la BDD est pas ouf ?", "answer"=>"JSP", "id"=>1]]]);
        }
        return $twig->render('faq.html', ["title"=>"FAQ", "faq"=>$data]);
    }

    static public function manage(){
        global $twig;
        if (self::needToBeAdmin()){
            //c'est pas un admin
            return "";
        }
        $data = Faq::getFaq();
        if (!$data){
            //Il y a eu un souci dans la requête de la BDD
            return $twig->render('manageFaq.html', ["title"=>"noFAQ", "faq"=>[["question"=>"PK la BDD est pas ouf ?", "answer"=>"JSP", "id"=>1]]]);
        }
        return $twig->render('manageFaq.html', ["title"=>"FAQ", "faq"=>$data]);
    }

}

