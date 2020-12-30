<?php


namespace App\Model;


class UserListAdmin
{
    public static function AddAccount($info_add)
    {
        global $DB;
        $insert_user = $DB->prepare("INSERT INTO user(firstname, lastname, sex, mail, birthdate, language, 
                 password, token, urlavatar, grade) VALUES(:firstname, :lastname, :sex, :mail, :birthdate, :language, 
                :password, :token, :urlavatar, :grade)"); //On importe toute la table des users
        $insert_user ->execute($info_add);
        return 'ça marche ?';
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