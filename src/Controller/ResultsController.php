<?php


namespace App\Controller;

class ResultsController extends Controller
{
    static public function show(){
        global $twig;
				$url = "http://projets-tomcat.isep.fr:8080/appService?ACTION=GETLOG&TEAM=AG4E";
				$ch = curl_init($url);
				$data = curl_exec($ch);
				/* curl_setopt( */
				/* 		$ch, */
				/* 		CURLOPT_URL, */
				/* 		"http://projets-tomcat.isep.fr:8080/appService?ACTION=GETLOG&TEAM=A11D"); */
				/* curl_setopt($ch, CURLOPT_HEADER, FALSE); */
				/* curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); */
				/* $data = curl_exec($ch); */
				curl_close($ch);
        return $twig->render('results.html', ['results' => $data]);
    }

    static public function led(){
        global $twig;
        return $twig->render('led.html');
    }

    static public function toggleLed(){
				$url = "http://projets-tomcat.isep.fr:8080/appService/?ACTION=COMMAND&TEAM=AG4E&TRAME=1AG4E16010001b7";
				$ch = curl_init($url);
				$data = curl_exec($ch);
				/* curl_setopt( */
				/* 		$ch, */
				/* 		CURLOPT_URL, */
				/* 		"http://projets-tomcat.isep.fr:8080/appService?ACTION=GETLOG&TEAM=A11D"); */
				/* curl_setopt($ch, CURLOPT_HEADER, FALSE); */
				/* curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); */
				/* $data = curl_exec($ch); */
				curl_close($ch);
        return $data;
    }
}

