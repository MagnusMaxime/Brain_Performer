<?php

namespace App\Controller;


use App\Model\User;

class userListAdminController extends Controller
{
    static public function index(){
        global $twig;
    }

    public function show(){
        global $twig;
        if (self::needToBeAdmin())
        {
            //ça redirige sur la page d'accueil ça ?
            return "";
        }
        /*if (isset()){ //si le bouton "Ajouter un utilsateur est enclenché et que les champs minimums sont défini (mail, mdp, prénom, nom, date de de naissance, sexe, clé, grade ?)
        }*/
        return $twig->render('userListAdmin.html', ["title"=>"Gérer les utilisateurs",
                                                            'users' => User::getUsers()]);
    }
}

