<?php


namespace App\Model;


class UserListAdmin
{
    public static function AddAccount($info_add)
    {
        global $DB;
        $insert_user = $DB->prepare("INSERT INTO user(firstname, lastname, sex, mail, birthdate, language,
                 password, token, urlavatar, grade, parent) VALUES(:firstname, :lastname, :sex, :mail, :birthdate, :language,
                :password, :token, :urlavatar, :grade, :parent)"); //On importe toute la table des users
        $insert_user ->execute($info_add);
        return 'ça marche ?';
    }

    public static function SaveModification()
    {
    }

    public static function RemoveAccount($id_del)
    {
        global $DB;
        $delete_users = $DB->prepare("DELETE FROM user WHERE id=:id_del");
        $delete_users->execute(array("id_del" => $id_del));
    }

    public static function ModifieAccount()
    {
    }
}