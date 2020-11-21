<?php


namespace App\Router;


class Route
{
    private $path;
    private $callable;

    public function __construct($path, $callable)
    {
        $this->path = trim($path,'/');
        $this->callable = $callable;
    }
    public function match($url){
        $url = trim($url, '/');
        $path = preg_replace('#:([\w]+)#','([^/]+)', $this->path);#C'est pour prendre en compte les paramètres


        if (!preg_match("#^$path$#i", $url, $matches)){ #vive les regex, drapeau i pour être sensible à la casse
            return false;
        }
        array_shift($matches);
        #var_dump($matches);
        $this->matches = $matches;
        return true;
    }

    public function call(){
        return call_user_func_array($this->callable, $this->matches);
    }
}
