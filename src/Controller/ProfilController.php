<?php


namespace App\Controller;


class ProfileController
{
    protected $viewPath;

    public function __construct() {
        $this->viewPath = ROOT . '/Views/';
    }

    public function show($id){
        echo "Je présente le profil ".$id;
    }

    public function render($view, $variables = []) {
        ob_start();
        extract($variables);
        require($this->viewPath . $view);
        $content = ob_get_clean();
        require($this->viewPath . 'templates/' . $this->template . '.php');
    }
}
