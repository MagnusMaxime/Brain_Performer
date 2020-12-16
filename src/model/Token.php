<?php
namespace App\Model;


class Token{
    public static function isDoctorToken($token){
        global $DB;
        $req = $DB->prepare("SELECT * FROM `token` WHERE `id` = :token");
        $results = $req->execute(["token"=>$token]);
        if (!$results){
            //Il y a eu un souci dans la requête de la BDD
            throw new \Exception("Souci dans la requête SQL");
        }
        return $req->rowCount()>=1;
    }
    public static function destroyDoctorToken($token){
        global $DB;
        $req = $DB->prepare("DELETE FROM `token` WHERE `id` = :token");
        $result = $req->execute(["token"=>$token]);
        return $result;

    }

    public static function isPatientToken($token){
        global $DB;
        $req = $DB->prepare("SELECT * FROM `user` WHERE `token` = :token");
        $results = $req->execute(["token"=>$token]);
        $isPatientToken = $req->rowCount()>=1;
        if (!$isPatientToken){
            return false;
        }
        $doctor = $req->fetch();//on recup la première ligne des résultats
        $user = new User($doctor["id"]);
        return $user;
    }


}
