<?php

use App\Controllers\ProductController;
use App\Routing\Router;

require_once __DIR__. '/../vendor/autoload.php';

$router = new Router();


$router->add("GET", "products", ProductController::class, "index");
$router->add("GET", "products/show", ProductController::class, "show");
$router->add("PUT", "products/update", ProductController::class, "update");
$router->add("DELETE", "products/delete", ProductController::class, "delete");
//$router->add($requestMethod, $requestURI, ProductController::class, "index");

//"ProductController::class"
$router->add("POST", "products", ProductController::class, "store");
$router->add("GET", "products/delete", ProductController::class, "delete");



header('Content-Type: application/json' );
try {

    echo $router->dispatch();

}
catch (Exception $exception){
    //echo exception message
    $errorCode = $exception->getCode();
    if( $exception instanceof \PDOException){
        $errorCode = 500;
    }
    $data = [
        "errorMessage" => $exception->getMessage(),
        "errorCode" => $errorCode
    ];
    
    

    http_response_code( $errorCode );
    echo json_encode(["data" => $data], JSON_PRETTY_PRINT);
    // if($exception->getCode() === 404){
    //     include __DIR__."/../views/404.php";
    //     exit;
    // }
    //along with the exception code
}


//dispatch a route
//localhost:8889/products