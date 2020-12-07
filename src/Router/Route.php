<?php

namespace App\Router;


class Route
{
    private $path;
    private $callable;

    public function __construct($path, $callable)
    {
        $this->path = trim($path, '/');
        $this->callable = $callable;
    }
    public function match($url){

        $url = trim($url, '/');
        $path = preg_replace('#:([\w]+)#','([^/]+)', $this->path);#C'est pour prendre en compte les paramètres

        if (!preg_match("#^$path$#i", $url, $matches)){ #vive les regex, drapeau i pour être sensible à la casse
            return false;
        }
        array_shift($matches);
        #die($path."##".$url);
        #var_dump($matches);
        $this->matches = $matches;
        return true;
    }

    public function call(){
        if (is_string($this->callable)){#si $this->callable est un str
            $params = explode("#", $this->callable);
            $controller = "App\\Controller\\".$params[0]."Controller";
            $controller = new $controller(); #Merci PHP d'être un langage de haut niveau
            return call_user_func_array([$controller, $params[1]], $this->matches);
            $action= $params[1];
            return $controller->$action(); #Note : on ne peut pas directement remplacer $action par son expression
        } else {
            return call_user_func_array($this->callable, $this->matches);
        }
    }

    public function getUrl($params){
        $path=$this->path;

        foreach ($params as $k=>$v) {
            $path = str_replace(":$k", $v, $path);
        }
        return $path;
    }
}
