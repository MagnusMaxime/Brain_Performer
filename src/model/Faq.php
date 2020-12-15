<?php


namespace App\Model;


class Faq {
    public static function getFaq(){//retourne un array avec les questions et les réponses
        global $DB;
        $req = $DB->prepare("SELECT question, answer, created, updated FROM `faq`");
        $results = $req->execute();
        $data = $req->fetch();
        var_dump($results);
        var_dump($data);


    }
}
