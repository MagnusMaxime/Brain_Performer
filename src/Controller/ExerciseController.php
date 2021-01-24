<?php


namespace App\Controller;


class ExerciseController extends Controller
{
    static public function show(){
        global $twig;
        return $twig->render('exercises.html', ["title"=>"mes exercices"]);
    }

    static public function one(){
        global $twig;
        return $twig->render('exercise.html', ["title"=>"Mon exercice"]);
    }


}
