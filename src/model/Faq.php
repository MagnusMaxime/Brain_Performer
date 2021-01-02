<?php

namespace App\Model;


class Faq extends SQLTable {
    public static function getFaq(){//retourne un array avec les questions et les réponses
        global $DB;
        $req = $DB->prepare("SELECT * FROM `faq`");//id,question, answer, created, updated
        $results = $req->execute();
        if (!$results){
            //Il y a eu un souci dans la requête de la BDD
            return false;
        }
        $data = $req->fetchAll();
        return $data;

    }

    public static function addFaq($question, $answer){
        //ajoute la question et la réponse à la BDD
        global $DB;
        $req = $DB->prepare("INSERT INTO `faq` (`question`, `answer`) VALUES (:question, :answer);");
        $result = $req->execute(["question"=>$question, "answer"=>$answer]);
        return $result;
    }

    public static function modifyFaq($id, $question, $answer){
        global $DB;
        $req = $DB->prepare("UPDATE `faq` SET `question` = :question, `answer` = :answer WHERE `faq`.`id` = :id;");
        $result = $req->execute(["id"=>$id,"question"=>$question, "answer"=>$answer]);
        return $result;

    }

    public static function removeQuestion($id){
        global $DB;
        $req = $DB->prepare("DELETE FROM `faq` WHERE `faq`.`id` = :id");
        $result = $req->execute(["id"=>$id]);
        return $result;
    }

}
//Format de $data :
//array(2) { [0]=> array(8) { ["question"]=> string(42) "Qui peut faire un compte Brain Performer ?" [0]=> string(42) "Qui peut faire un compte Brain Performer ?" ["answer"]=> string(574) "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum." [1]=> string(574) "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum." ["created"]=> string(19) "2020-12-15 17:23:11" [2]=> string(19) "2020-12-15 17:23:11" ["updated"]=> string(19) "2020-12-15 17:23:11" [3]=> string(19) "2020-12-15 17:23:11" } [1]=> array(8) { ["question"]=> string(29) "Qui a crée Brain Performer ?" [0]=> string(29) "Qui a crée Brain Performer ?" ["answer"]=> string(4) "Nous" [1]=> string(4) "Nous" ["created"]=> string(19) "2020-12-15 17:24:59" [2]=> string(19) "2020-12-15 17:24:59" ["updated"]=> string(19) "2020-12-15 17:24:59" [3]=> string(19) "2020-12-15 17:24:59" } }
