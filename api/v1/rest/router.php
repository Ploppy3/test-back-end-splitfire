<?php

require 'helper.php';
require 'controller.php';

class Router {

    private $relativeUrl = "";
    private $routes = array();

    function __construct(){
        spl_autoload_register(function($class) {
            //*
            foreach (glob("controllers/*.controller.php") as $filename)
            {
                require $filename;
            }
            //*/
        });

        global $__ngn_isJSONP__;
        $__ngn_isJSONP__ = false;

        //echo 'constructor : ApiController <br>';

        $apiVersion = null;

        $url = "$_SERVER[REQUEST_URI]";
        //var_dump($url);
        $pos = strrpos($url, '?');
        if(strpos($url, '?'))
            $url = substr($url, 0, strrpos($url, '?'));
        //var_dump($url);
        $url = substr($url, strrpos($url, 'api/') + 4, strlen($url));
        //var_dump($url);

        $urlParts = explode('/', $url);
        //var_dump($urlParts);
        if(preg_match('/v[0-9]+/', $urlParts[0]))
            $apiVersion = str_replace('v', '', $urlParts[0]);
        else 
            throwError(400, 'bad URL, missing API version, try \'/api/v1/...\'');
        //var_dump($apiVersion);

        $url = substr($url, stripos($url, '/'), strlen($url));
        //var_dump($url);
        $this->relativeUrl = $url;
    }

    function setJSONP($isJSONP=true){
        global $__ngn_isJSONP__;
        $__ngn_isJSONP__ = $isJSONP;
    }
    
    function addRoute($route=null, Controller $controller){
        $matches = array();
        $urlParams = array();
        $urlParts = explode('/', $route);
        $routeRegEx = "/";
        $i = 0;
        foreach($urlParts as $part){
            if(strlen($part) == 0)
                continue;
            $routeRegEx .= "\/";
            if(preg_match('/{[^\/]*}/', $part)) {
                $routeRegEx .= "[^\/]+";
                $part = str_replace(array('{','}'), '', $part);
                $urlParams[$i] = $part; 
            }
            else 
                $routeRegEx .= $part;
            $i++;
        }
        $routeRegEx .= "/";
        //var_dump($routeRegEx);
        array_push($this->routes, new Route($routeRegEx, $controller, $urlParams));
    }

    function run(){
        //*
        try{
        //*/
            $selectedRoute = null;
            $selectedRegex= "";
            foreach($this->routes as $route){
                //echo 'checking for regex : ' . $route->regex . '<br>';
                if(preg_match($route->regex, $this->relativeUrl)) {
                    //echo 'matched <br>';
                    $urlParts = explode('/', $this->relativeUrl);
                    $i = 0;
                    foreach($urlParts as $part){
                        if(strlen($part) == 0)
                            continue;
                        if(array_key_exists($i, $route->urlParams))
                            $route->controller->addUrlParam($route->urlParams[$i], $part);
                        $i++;
                    }
                    if(strlen($route->regex) > strlen($selectedRegex)){
                        //echo 'route found <br>';
                        $selectedRegex = $route->regex;
                        $selectedRoute = $route;
                    }
                }
            }
            if($selectedRoute){
                global $__ngn_isJSONP__;
                if($__ngn_isJSONP__)
                    checkCallback();
                switch ($_SERVER['REQUEST_METHOD']) {
                    case 'GET':
                        //echo 'Method GET';
                        $selectedRoute->controller->get();
                        break;
                    case 'POST':
                        //echo 'Method POST';
                        $selectedRoute->controller->post();
                        break;
                    case 'PUT':
                        //echo 'Method PUT';
                        $selectedRoute->controller->put();
                        break;
                    case 'DELETE':
                        //echo 'Method DELETE';
                        $selectedRoute->controller->delete();
                        break;
                    case 'OPTIONS':
                        //echo 'Method DELETE';
                        $selectedRoute->controller->options();
                        break;
                    
                    default:
                        throwError(400, 'Unknown HTTP Method, API currently supports GET/POST/PUT/DELETE');
                        break;
                }
            } else 
                throwError(400, 'this route does not exist');
        //*
        } catch (Exception $e) {
            //throwError(500, "API failure");
            throwError(500, $e->getMessage());
        }//*/
    }
}

class Route {
    public $regex;
    public $controller;
    public $urlParams = array();
    function __construct($regex="", Controller $controller, array $urlParams){
        //echo 'constructor : Route <br>';
        $this->regex = $regex;
        $this->controller = $controller;
        $this->urlParams = $urlParams;
    }
}