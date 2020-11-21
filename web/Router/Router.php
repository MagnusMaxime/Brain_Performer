<?php
namespace App\Router;
require_once('Route.php');
require_once('RouterException.php');
class Router{
    private  $url;
    private $routes=[];
    public function __construct($url){

        $this->url = $url;

    }

    public function get($path, $callable){
        $route = new Route($path,$callable);
        $this->routes['GET'][]=$route;
    }
    public function post($path, $callable){
        $route = new Route($path,$callable);
        $this->routes['POST'][]=$route;
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
}
