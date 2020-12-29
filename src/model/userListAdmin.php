<?php


namespace App\Model;


class userListAdmin
{
    public static function AddAccount()
    {
        global $DB;
        $insert_user = $DB->prepare("INSERT INTO user(firstname, lastname, sex, mail, birthdate, language, password, token, urlavatar, grade) VALUES(:firstname, :lastname, :sex, :mail, :birthdate, :language, :password, :token, :urlavatar, :grade)"); //On importe toute la table des users
        $insert_user ->execute(array(
            '' => $firstname,
            '' => $lastname,
            '' => $sex,
            '' => $mail,
            '' => $birthdate,
            '' => $language,
            '' => $password,
            '' => $token,
            '' => $urlavatar,
            '' => $grade
        ));

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