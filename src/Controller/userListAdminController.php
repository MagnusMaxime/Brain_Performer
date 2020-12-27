<?php

namespace App\Controller;

class userListAdminController extends Controller
{
    static public function index(){
        global $twig;
        #die("ok");
        return $twig->render('userListAdmin.html', []);
    }
    public function show(){
        global $twig;
        return $twig->render('userListAdmin.html', []);
    }
}
