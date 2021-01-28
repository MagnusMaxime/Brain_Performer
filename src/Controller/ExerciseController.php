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
        $user = new User($data["owner"]);
        $user_info=$user->get_info();
        if ($data["public"]=="0"){
            //l'exercice est privé
            if (self::needToBeConnected()){//l'utilisateur est pas connecté et a besoin d'être connecté
                return "";
            }
            if ($data["owner"]!=$_SESSION["id"]){

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
        $data["owner_name"]=$user_info["firstname"]." ".$user_info["lastname"];
        $data["table1"]=[[1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
            [108, 110, 112, 114, 118, 120, 124, 118, 121, 124]];
        $data["table2"]=[];
        foreach ($data["table1"][0] as $k=>$v){
            $data["table2"][]=["x"=>$data["table1"][0][$k],"y"=>$data["table1"][1][$k]];
        }
        return $twig->render('exercise.html', $data);


    }

    static public function user(){
        global $twig;
        if (self::needToBeConnected()){
            //l'utilisateur est pas connecté et a besoin d'être connecté
            return "";
        }
        return self::showUserExercises($_SESSION["id"]);
    }
    static public function showUserExercises($id){
        global $twig;
        $user = new User($id);
        $user_info=$user->get_info();
        if ($user_info["public"]=="0"){
            //l'exercice est privé
            if (self::needToBeConnected()){//l'utilisateur est pas connecté et a besoin d'être connecté
                return "";
            }
            if ($id!=$_SESSION["id"]){
                if ($user_info["parent"]!=$_SESSION["id"]){
                    //ce n'est pas le médecin du patient, on bloque
                    header("Location: /");
                    return "";
                }
            }
        }

        $twig_array=[];
        $twig_array["exercises"]=Exercise::getExerciseOfUser($id);

        $twig_array["title"]="Exercices";

        return $twig->render('exercises.html', $twig_array);
    }

}
