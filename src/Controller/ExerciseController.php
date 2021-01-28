<?php


namespace App\Controller;


use App\Model\Exercise;
use App\Model\User;

class ExerciseController extends Controller
{
    static public function show(){
        global $twig;
        return $twig->render('exercises.html', ["title"=>"mes exercices"]);
    }

    static public function one($id){
        global $twig;
        $data=Exercise::getExercise($id);
        if ($data["public"]=="0"){
            //l'exercice est privé
            if (self::needToBeConnected()){//l'utilisateur est pas connecté et a besoin d'être connecté
                return "";
            }
            if ($data["owner"]!=$_SESSION["id"]){
                $user = new User($data["owner"]);
                $user_info=$user->get_info();
                if ($user_info["parent"]!=$_SESSION["id"]){
                    //ce n'est pas le médecin du patient, on bloque
                    header("Location: /");
                    return "";
                }
            }
        }
        if ($data===false){
            //l'exercice n'existe pas
            header("Location: /");
            return "";
        }
        $data["title"]="Mon exercice";
        //var_dump($data);
        return $twig->render('exercise.html', $data);


    }

    static public function user(){
        global $twig;
        if (self::needToBeConnected()){
            //l'utilisateur est pas connecté et a besoin d'être connecté
            return "";
        }
        $twig_array=[];
        $twig_array["exercises"]=Exercise::getExerciseOfUser($_SESSION["id"]);
        $twig_array["title"]="Mes exercices";
        return $twig->render('exercises.html', $twig_array);
    }


}
