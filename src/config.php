<?php
namespace App\Controller;


class Config {
    /* Documentation de Twig: https://twig.symfony.com/doc/3.x/intro.html */
    /* const PATH_TEMPLATES = __DIR__ . "/views"; */
    /* const PATH_CACHE = __DIR__ . "/cache"; */
    protected static $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . "/views");
    protected static $twig = new \Twig\Environment($loader, [
        /* 'cache' => PATH_CACHE, */ # À utiliser uniquement en production (ajouter var env)
    ]);
}
