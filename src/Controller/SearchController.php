<?php

namespace App\Controller;


use App\Model\User;


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
        foreach ($data as $key => $user_info) {

            if (intval($user_info["grade"])>=2){
                //on affiche pas les comptes de gestionnaire, admin ou dev
                continue;
            }

            if ($user_info["public"]=="1"){
                //l'utilisateur $user est public, on l'affiche
                $result[]=removeSensibleInfo($user_info);
                continue;
            }
            if (isset($_SESSION['id'])){
                if ($_SESSION["id"]==$user_info["id"]){
                    //Un utilisateur peut voir son propre profil
                    $result[]=removeSensibleInfo($user_info);
                    continue;
                }
                if (intval($user_info["grade"])==0 and $user_info["parent"]==$_SESSION["id"]){
                    //un utilisateur peut voir ses enfants même s'ils sont privés.
                    $result[]=removeSensibleInfo($user_info);
                    continue;
                }
                if ($_SESSION["grade"]>=2){
                    //Un admin peut voir tout le monde
                    $result[]=removeSensibleInfo($user_info);
                    continue;
                }
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

