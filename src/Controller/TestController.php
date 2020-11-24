<?php

namespace App\Controller;

class TestController extends Controller
{
    static function test($id) {
        if ($id==1) {
            return "This is a test.";
        } elseif ($id==2){
            global $twig;
            return $twig->render('index.html');
        }
    }
}
