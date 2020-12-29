<?php


namespace App\Model;


class userListAdmin
{
    public static function AddAccount()
    {
        global $DB;
        //$users_data = $DB->prepare("INSERT INTO user(mail, firstname, lastname, sex, birthdate, password, language, token, urlavatar, parent, grade) VALUES(?,?,?,?,?,?,?,?,?,?)"); //On importe toute la table des users
        $results = $users_data->execute();

    }

    public static function SaveModification()
    {
    }

    public static function RemoveAccount()
    {
    }

    public static function ModifieAccount()
    {
    }
}