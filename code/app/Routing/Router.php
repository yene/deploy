<?php

namespace App\Routing;

use Exception;

class Router
{
    protected $routes = [];

    public function add(string $method, string $path, string $controllerName, string $action)
    {
        // $control = new $controllerName;
        // $control->index();
        return $this->routes[] = array("method" => $method, "path" => $path, "controller" => $controllerName, "action" => $action);
    }


    //dispatch function
    // find the matching route $this->findRoute()
    // get the controller from the returned route
    //get action from the retuned route
    // instantiate the controller and call the action/method

    public function dispatch()
    {
        $id = null;
        $route = $this->findRoute();
        $path = $route['path'];
        $controller = $route['controller'];
        // echo "this is controller";
        // print_r($controller);
        // echo "end of controller";
        $action = $route['action'];

        if (preg_match("/[\d]+/", $path, $matches)) {
            $digitsFromPath = (int)implode(" ", $matches);
            //$tableColumns['id'] = $id;
            $id = $digitsFromPath;
        }

        $controller = new $controller; //very interesting to initiate a new object from a path!
        return $controller->$action($id); //very interesting to call a method from a name in the assoc array!

    }

    public function findRoute()
    {

        $requestURI = trim($_SERVER['REQUEST_URI'], "/");
        $requestMethod = $_SERVER['REQUEST_METHOD'];


        foreach ($this->routes as $route) {


            //In case there is an ID
            if (preg_match("/[\d]+/", $requestURI)) {
                //echo "THERE ARE DIGITS!!";
                $str = preg_replace("/[\d]+/", '{$0}', $requestURI); //people/show/9
                // //$str = preg_replace("/[\d]+/", 'show', $requestURI);
                //echo "this is the new string $str";
                $route['method'] = $requestMethod;
                $route['path'] = $str;
                preg_match("/^[a-zA-Z]+\/([a-zA-Z]+)\/[\d]+$/", $requestURI, $matches);
                //echo "matches is ";
                //print_r($matches[1]);
                $action = $matches[1];
                $route['action'] = $action;
                echo " there is an id, so this is the new route";
                print_r($route);
                return $route;
            }

            if ($route['method'] === $requestMethod && $route['path'] === $requestURI) {
                //echo "this is the part of array filtered out";
                // print_r($route);

                return $route;
            }
        }

        throw new Exception('Route not found', 404);
    }

    public function printRoutes()
    {
        echo "<pre>";
        print_r($this->routes);
        echo "</pre>";
    }
}


// add("GET", "products", "ProductController::class", "index")