<?php
//Fichier qui contient des fonctions pratiques

function console_log( $data ){
    echo '<script>console.log('. json_encode( $data ) .')</script>';
}

$router->get('/faq', function() use ($twig) {
    echo $twig->render("faq.html", ["title"=>"FAQ"]);
});
