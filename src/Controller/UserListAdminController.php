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
        global $twig;
        return $twig->render('userListAdmin.html', ["title" => "Gérer les utilisateurs",
            'users' => User::getUsers()]);
    }

    public function postadd()
    {
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
                'parent' => $_SESSION['id']
            );
            UserListAdmin::AddAccount($info_add);
            //var_dump($info_add);
            header("Location: /admin/gestion-utilisateurs");
        }
        else
        {
            var_dump($_POST);
            echo "ëtes-vous certain d'être un administrateur ?";
                    //header("Location: /connexion");
        }

    }

    public function postupdate()
    {
    }

    static public function delete($id)
    {
        echo "je suis là";
        UserListAdmin::RemoveAccount($id);
        header("Location: /admin/gestion-utilisateurs");
    }

    static public function addrequired()
    {
        return (isset($_POST['firstname'], $_POST['lastname'], $_POST['sex'], $_POST['mail'], $_POST['birthdate'],
            $_POST['language'], $_POST['password'], $_POST['grade']));
    }
}

