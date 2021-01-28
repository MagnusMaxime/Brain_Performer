<?php


namespace App\Controller;


use App\Model\Exercise;

class ExerciseController extends Controller
{
    static public function show(){
        global $twig;
        return $twig->render('exercises.html', ["title"=>"mes exercices"]);
    }

    static public function one($id){
        global $twig;
        $data=Exercise::getExercise($id);
        if ($data===false){
            //l'exercice n'existe pas
            header("Location: /");
            return "";
        }
        $data["title"]="Mon exercice";
        //var_dump($data);
        return $twig->render('exercise.html', $data);
    }


}
