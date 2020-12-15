<?php


namespace App\Model;


class Ticket{
    public static function getTickets(){//retourne un array avec les questions et les réponses
        global $DB;
        $req = $DB->prepare("SELECT * FROM `ticket`");//id,question, answer, created, updated
        $results = $req->execute();
        if (!$results){
            //Il y a eu un souci dans la requête de la BDD
            return false;
        }
        $data = $req->fetchAll();
        return $data;
    }
    public static function postTicket($user_id, $message){
        global $DB;
        $req = $DB->prepare(
            "INSERT INTO `ticket` (`user`, `message`) VALUES (:id_user , :message);");
        $result=$req->execute(["id_user"=>$user_id,"message"=>$message]);
        //var_dump($DB->errorInfo());
        return $result;
    }

}
