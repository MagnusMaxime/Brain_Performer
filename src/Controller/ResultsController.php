<?php


namespace App\Controller;

class ResultsController extends Controller
{
    static public function show(){
        global $twig;
				$img_on = "https://cdn.discordapp.com/attachments/834078282924163106/856908948338507786/unknown.png";
				$img_off = "https://cdn.discordapp.com/attachments/834078282924163106/856908983134060574/unknown.png";
				$output = shell_exec('curl -L "http://projets-tomcat.isep.fr:8080/appService?ACTION=GETLOG&TEAM=AG4E"');
				$arr = str_split($output, 33);
				$pattern_on = "1AG4E13010002789";
				$pattern_off = "1AG4E13010000789";
				$detected = false;
				$result = false;
				for($i=count($arr)-1; $i>0; $i--) {
					if (str_starts_with($arr[$i], $pattern_on)) {
						$detected = true;
						$result = true;
						break;
					}
					if (str_starts_with($arr[$i], $pattern_off)) {
						$detected = true;
						$result = false;
						break;
					}
				}
        return $twig->render('results.html', ['results' => $output, 'img_on' => $img_on, 'img_off'=>$img_off, 'result' => $result, 'detected' => $detected]);
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

