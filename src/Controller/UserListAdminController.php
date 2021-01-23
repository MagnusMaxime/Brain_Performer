<?php

namespace App\Controller;

use App\Model\User;
use App\Model\UserListAdmin;

class UserListAdminController extends Controller
{
    static public function index()
    {
        global $twig;
    }

    public function get()
    {
        if (self::needToBeAdmin()) {
            return "";
        }
        global $twig;
        return $twig->render('userListAdmin.html', ["title" => "Gérer les utilisateurs",
            'users' => User::getUsers()]);
    }

    public function postadd()
    {
        if (self::needToBeAdmin()) {
            return "";
        }
        global $twig;
        if (self::addrequired())
        {
            echo "les champs sont remplis";
            //si le bouton "Ajouter un utilsateur est enclenché et que les champs minimums sont défini (mail, mdp, prénom, nom, date de de naissance, sexe, clé, grade ?)

            $info_add = array(
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],
                'sex' => $_POST['sex'],
                'mail' => $_POST['mail'],
                'birthdate' => $_POST['birthdate'],
                'language' => $_POST['language'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),//à hacher
                'token' => $_POST['token'],
                'urlavatar' => $_POST['urlavatar'],
                'grade' => $_POST['grade'], //à mettre sous forme de numéro
                'parent' => $_SESSION['id'],
                'public' => $_POST['public']
            );

            UserListAdmin::AddAccount($info_add);
            //var_dump($info_add);
            //header("Location: /admin/gestion-utilisateurs");
            return $this->get();
        }
        else
        {
            var_dump($_POST);
            echo "Êtes-vous certain d'être un administrateur ?";
                    //header("Location: /connexion");
        }

    }

    public function postupdate($id) //on modifie les champs avec les infos récupérés
    {
        if (self::needToBeAdmin()) {
            return "";
        }
        $update_user = array(
            'firstname' => $_POST['firstname'],
            'lastname' => $_POST['lastname'],
            'sex' => $_POST['sex'],
            'mail' => $_POST['mail'],
            'birthdate' => $_POST['birthdate'],
            'language' => $_POST['language'],
            //'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'token' => $_POST['token'],
            'urlavatar' => $_POST['urlavatar'],
            'grade' => $_POST['grade'],
            'public' => $_POST['public'],
            'id' => $id
        );
        if ($_POST['password']!=""){
            $update_user["password"]=password_hash($_POST['password'], PASSWORD_DEFAULT);
        }else{
            $update_user["password"]="";
        }
        //var_dump($update_user);
        UserListAdmin::ModifieAccount($update_user);
        return $this->get();


    }

    static public function delete($id)
    {
        if (self::needToBeAdmin()) {
            return "";
        }
        echo "je suis là";
        UserListAdmin::RemoveAccount($id);
        header("Location: /admin/gestion-utilisateurs");
    }

    static public function addrequired()
    {
        if (self::needToBeAdmin()) {
            return "";
        }
        return (isset($_POST['firstname'], $_POST['lastname'], $_POST['sex'], $_POST['mail'], $_POST['birthdate'],
            $_POST['language'], $_POST['password'], $_POST['grade'], $_POST['public']));
    }
}

