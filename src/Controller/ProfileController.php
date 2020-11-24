<?php

namespace App\Controller;

class ProfileController extends Controller
{
    protected $viewPath;

    public function __construct() {
        /* $this->viewPath = ROOT . '/Views/'; */
    }

    public function render($id){
        return "Je présente le profil ".$id;
    }

    public function index() {
        return "La liste des profils est ici";
    }

    /* public function render($id) { */
    /*     /1* ob_start(); *1/ */
    /*     /1* extract($variables); *1/ */
    /*     /1* require($this->viewPath . $view); *1/ */
    /*     /1* $content = ob_get_clean(); *1/ */
    /*     /1* /2* require($this->viewPath . 'templates/' . $this->template . '.php'); *2/ *1/ */
    /*     /1* ob_end_clean(); *1/ */
    /*     /1* echo $content; *1/ */
    /*     /1* echo 'vive le render'; *1/ */
    /*     echo $twig->render('profile.php', compact($id)); */
    /* } */
}
