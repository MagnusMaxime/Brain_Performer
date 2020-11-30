<?php
namespace App\Router;
require_once('Route.php');
require_once('RouterException.php');

#Router de Graphikart : https://www.youtube.com/watch?v=I-DN2C7Gs7A
class Router{
    private $url;
    private $routes=[];
    private $namedRoutes=[];
    public function __construct($url){
        $this->url = $url;
    }

    private function add($path, $callable, $name, $method){
        $route = new Route($path,$callable);
        $this->routes[$method][]=$route;
        if (is_string($callable) && $name===null){
            $name=$callable;#On appelle la route par le nom du controller
        }
        if ($name){
            $this->namedRoutes[$name]=$route;
        }
        return $route;
    }

    public function get($path, $callable, $name=null){
        return $this->add($path, $callable, $name, "GET");
    }
    public function post($path, $callable, $name=null){
        return $this->add($path, $callable, $name, "POST");
    }

    public function run(){
        #echo("<pre>".print_r($this->routes)."</pre>");
        if (!isset($this->routes[$_SERVER['REQUEST_METHOD']])){
            throw new RouterException('Request_method');
        }
        #var_dump($this->url);
        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route){
            if ($route->match($this->url)){
                return $route->call();
            }
        }
        throw new RouterException('No matching routes');
    }

    public function url($name, $params=[]){
        if (!isset($this->namedRoutes[$name])){
            throw new RouterException("No route matches this name");
        }
        return $this->namedRoutes[$name]->getUrl($params);
    }
}
