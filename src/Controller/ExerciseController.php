<?php


namespace App\Controller;


class ExerciseController extends Controller
{
    static public function show(){
        global $twig;
        return $twig->render('exercises.html', []);
    }

}
