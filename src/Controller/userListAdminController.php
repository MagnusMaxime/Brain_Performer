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
        return $twig->render('userListAdmin.html', ["title"=>"Gérer les utilisateurs",
                                                            'users' => User::getUsers()]);
    }
}

