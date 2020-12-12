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
            "firstname"=>$data["first-name"],
            "lastname"=>$data["last-name"],
            "mail"=>$data["email"],
            "sex"=>$data["gender"]=="man" ? 0 : 1,
            "birthdate"=>$data["birthday"],
            "token"=>$data["bp-key"],
            "password"=>password_hash($data["password"], PASSWORD_DEFAULT),//https://www.php.net/manual/fr/function.password-hash.php
            "language"=>"fr",//todo
            "urlavatar"=>$data["url-avatar"],

        ];
        //var_dump($array);
        //var_dump($DB);
        $req = $DB->prepare(
            "INSERT INTO `user` (`firstname`, `lastname`, `mail`, `sex`, `birthdate`, `token`, `password`, `language`, `urlavatar`) VALUES (:firstname, :lastname, :mail, :sex, :birthdate, :token, :password, :language, :urlavatar);");
        $req->execute($array);
        return true;
    }

    static public function connect($mail, $password){
        global $DB;
        $req = $DB->prepare("SELECT * FROM user WHERE mail = ? AND password = ?");
        $req->execute([$mail, password_hash($password, PASSWORD_DEFAULT)]);
        $userexist = $req->rowCount();
        if($userexist == 1) {
            $userinfo = $req->fetch();
            $_SESSION['id'] = $userinfo['id'];
            $_SESSION['firstname'] = $userinfo['firstname'];
            $_SESSION['lastname'] = $userinfo['lastname'];
            $_SESSION['mail'] = $userinfo['mail'];
            $_SESSION['sex'] = $userinfo['sex'];
            $_SESSION['language'] = $userinfo['language'];
            $_SESSION['urlavatar'] = $userinfo['urlavatar'];
            $_SESSION['updated'] = $userinfo['updated'];
            $_SESSION['created'] = $userinfo['created'];
            header("Location: profil.php?id=".$_SESSION['id']);
            return true;
        } else {
            //Mauvais mail ou mot de passe !
            return false;
        }

    }

}
