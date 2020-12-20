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

    static public function post(){
        global $twig;
        if (self::needToBeAdmin()){
            //c'est pas un admin
            return "";
        }
        if (isset($_POST["q_add"])){
            //l'admin veut ajouter une question
            $sucess=Faq::addFaq($_POST["q_add"], $_POST["a_add"]);
            return self::manage();
        }
        //l'admin veut modifier les questions existantes
        $sucess = true;
        foreach ($_POST as $key => $value){
            if ($key[0]!="q"){
                continue;
            }
            $id=substr($key, 1);//on retire le "q" pour avoir l'id de la question pour MySQL
            if ($_POST["r".$id]=="yes"){//la question doit être retirée
                $sucess = $sucess and Faq::removeQuestion($id);
            }
            $sucess = $sucess and Faq::modifyFaq($id, $_POST["q".$id], $_POST["a".$id]);
        }
        return self::manage();

    }



}

