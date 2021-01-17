<?php

namespace App\Model;


class Sent extends SQLTable{
    public static function sentmessage($messagetxt,$recipient){
        global $DB;
        $req = $DB->prepare("INSERT INTO 'message' ('messagetxt','recipient') Values (':messagetxt',':recipient')");
        $result = $req->execute(["messagetxt"=>$messagetxt, "recipient"=>$recipient]);
        return $result;
    }
    public static function readmessage(){
        global $DB;
        $req = $DB->prepare("SELECT ('messagetxt','id','date','sender') FROM 'message'")
        $result = $req ->execute();
        if (!$result)
        {

            return false;
        }
        $data = $req->fetchAll();
        return $data;
     }

}
?>

