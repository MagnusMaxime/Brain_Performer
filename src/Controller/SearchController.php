<?php

namespace App\Controller;


use App\Model\User;

function a($array){

}

function removeNumericKeys($array)
{
    $result=[];
    foreach ($array as $key => $value) {

        if (!is_int($key)) {
            if (is_array($value)){
                $result[$key]=removeNumericKeys($value);
            }else{
                $result[$key]=$value;
            }
        }else{
            //var_dump($key);
        }
    }
    return $result;
}

function removeSensibleInfo($array){
    $result=$array;
    unset($result["password"]);
    unset($result["public"]);
    return $result;
}

class SearchController extends Controller
{

    static public function getArray(){
        $data=User::get_all_info();
        foreach ($data as $key=>$value){
            $data[$key]=removeNumericKeys($value);
        }
        $result = [];
        //var_dump($data);
        foreach ($data as $key => $user_info) {
            if ($user_info["public"]=="1"){
                //l'utilisateur $user est public, on l'affiche
                $result[]=removeSensibleInfo($user_info);
            }
        }
        return $result;
    }


    static public function show(){
        global $twig;
        $users_array=self::getArray();
        $twig_array=["json"=>json_encode($users_array), "title"=>"Rechercher", "users"=>$users_array];
        return $twig->render('search.html', $twig_array);
    }

    static public function api(){
        header('Content-Type: application/json');
        return json_encode(self::getArray());
    }

}

