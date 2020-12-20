<?php


namespace App\Controller;



class DashboardController extends Controller
{
    static public function show(){
        global $twig;
        if (self::needToBeAdmin()){
            //c'est pas un admin
            return "";
        }
        return $twig->render('adminDashboard.html', ["title"=>"Panneau de configuration"]);
    }


}
