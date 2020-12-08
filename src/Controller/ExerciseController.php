<?php


namespace App\Controller;


class ExerciseController extends Controller
{
    static public function showExercises(){
        global $twig;
        return $twig->render('exercises.html', []);
    }

}
