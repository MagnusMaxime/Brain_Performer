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

class SearchController extends Controller
{
    static public function show(){
        global $twig;

        return $twig->render('search.html', ["title"=>"Rechercher"]);
    }

    static public function api(){

        $data=User::get_all_info();
        $data1=[];
        foreach ($data as $key=>$value){
            $data1[$key]=removeNumericKeys($value);
        }
        var_dump($data1);

        $result = [];

        foreach ($data as $key => $user_info) {
            unset($key["password"]);
            unset($key["public"]);

            if ($user_info["public"]=="1"){
                //l'utilisateur $user est public, on l'affiche
                $result[]=$user_info;
            }
        }
        header('Content-Type: application/json');
        return json_encode($result);

    }

}

