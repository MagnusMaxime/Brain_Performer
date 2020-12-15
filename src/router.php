<?php
$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
//echo 'path: '.$path.'<br>'; //Si on fait des echo ici on détruit les CSS et JS
//echo $path=='/phpmyadmin';


/* error_log(print_r($path, TRUE)); */
/* if ($path=='/phpmyadmin'){ */
/* 	require __DIR__."/../phpmyadmin/"; */
if (!file_exists(__DIR__.$path)) {
	require "index.php";
} else {
	return false;
}
?>
