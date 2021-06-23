<?php


namespace App\Controller;

class ResultsController extends Controller
{
    static public function show(){
        global $twig;
				$output = shell_exec('curl -L "http://projets-tomcat.isep.fr:8080/appService?ACTION=GETLOG&TEAM=AG4E"');
				$arr = str_split($output, 33);
				$a = "1AG4E13010002789";
				$b = "1AG4E13010000789";
				$result = "nothing";
				for($i=count($arr)-1; $i>0; $i--) {
					if ($arr[$i] == $a) {
						$result = "on";
						break;
					}
					if ($arr[$i] == $b) {
						$result = "off";
						break;
					}
				}
        return $twig->render('results.html', ['results' => $output]);
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

