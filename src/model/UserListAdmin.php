<?php


namespace App\Model;


class UserListAdmin
{
    public static function AddAccount($info_add)
    {
        global $DB;
        $insert_user = $DB->prepare("INSERT INTO user(firstname, lastname, sex, mail, birthdate, language,
                 password, token, urlavatar, grade, parent, public ) VALUES(:firstname, :lastname, :sex, :mail,
                :birthdate, :language, :password, :token, :urlavatar, :grade, :parent, :public )"); //On importe toute la table des users
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

    public static function ModifieAccount($user_mod)
    {
        global $DB;
        if ($user_mod["password"]!="") {
            $req = $DB->prepare('UPDATE user SET firstname = :firstname, lastname = :lastname, sex = :sex,
            mail = :mail, birthdate = :birthdate, `language` = :language, password = :password, token = :token, 
            urlavatar = :urlavatar, grade = :grade, `public` = :public WHERE id = :id');
        } else{
            $req = $DB->prepare('UPDATE user SET firstname = :firstname, lastname = :lastname, sex = :sex,
            mail = :mail, birthdate = :birthdate, `language` = :language, token = :token, 
            urlavatar = :urlavatar, grade = :grade, `public` = :public WHERE id = :id');
            unset($user_mod["password"]);
        }


        $req->execute($user_mod);

    }
}
