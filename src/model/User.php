<?php


namespace App\Model;



class User{

    static public function register($data){
        global $DB;
        //["first-name"]=> string(2) "ze" ["last-name"]=> string(2) "ze"
        //["url-avatar"]=> string(0) "" ["gender"]=> string(3) "man"
        //["birthday"]=> string(10) "2020-12-22" ["email"]=> string(2) "ze"
        //["password"]=> string(15) "AGsJyF4t6vX7QNX" ["password-repeat"]=> string(15) "AGsJyF4t6vX7QNX"
        //["bp-key"]=> string(2) "ze" ["rememberme"]=> string(2) "on" }
        $array = [
            ""=>$data["email"],
            "firstname"=>$data["first-name"],
            "lastname"=>$data["last-name"],
            "sex"=>$data["gender"]=="man" ? 0 : 1,
            "birthdate"=>,
            "token"=>$data["bp-key"],
            "password"=>password_hash($data["password"], PASSWORD_DEFAULT),//https://www.php.net/manual/fr/function.password-hash.php
            "urlavatar"=>$data["url-avatar"],
            "language"=>"fr",//todo
        ]

        $req = $DB->prepare();

    }


}
