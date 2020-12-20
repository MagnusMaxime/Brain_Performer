<?php

namespace App\Controller;

/* echo __DIR__; */

/* echo PATH_TEMPLATES; */
/* echo FilesystemLoader; */
/* echo $$GLOBALS['twig']; */

class Controller
{
    /* protected $twig = $$GLOBALS['twig']; */
    /* global $twig; */
    /* static $twig = $GLOBALS["twig"]; */
    static public function checkRecaptcha($captcha){
    $url = 'https://www.google.com/recaptcha/api/siteverify?secret='.urlencode(RECAPTCHA_SECRET_KEY).'&response=' . urlencode($captcha);
    $response = file_get_contents($url);
    $responseKeys = json_decode($response, true);
    // should return JSON with success as true
    return $responseKeys["success"];
    }

    

}
