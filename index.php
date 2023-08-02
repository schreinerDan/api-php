<?php
include_once "./autoload.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    header("Access-Control-Max-Age: 3600");
    http_response_code(200);
    exit;
}
use Core\Router;

$router = new Router();

$router->addRoute('GET', '/products/get', 'ProductController', 'getAll');
$router->addRoute('GET', '/products/get/{id}', 'ProductController', 'getById');
$router->addRoute('POST', '/products/add', 'ProductController', 'create');
$router->addRoute('PUT', '/products/{id}', 'ProductController', 'update');
$router->addRoute('DELETE', '/products/{id}', 'ProductController', 'delete');

$router->addRoute('GET', '/sales/get', 'SaleController', 'getAll');
$router->addRoute('GET', '/sales/get/{id}', 'SaleController', 'getById');
$router->addRoute('POST', '/sales/add', 'SaleController', 'create');
$router->addRoute('PUT', '/sales/{id}', 'SaleController', 'update');
$router->addRoute('DELETE', '/sales/{id}', 'SaleController', 'delete');

$router->addRoute('GET', '/product-types/get', 'ProductTypeController', 'getAll');
$router->addRoute('GET', '/product-types/get/{id}', 'ProductTypeController', 'getById');
$router->addRoute('POST', '/product-types/add', 'ProductTypeController', 'create');
$router->addRoute('PUT', '/product-types/{id}', 'ProductTypeController', 'update');
$router->addRoute('DELETE', '/product-types/{id}', 'ProductTypeController', 'delete');

$router->addRoute('GET', '/users/get', 'UserController', 'getAll');
$router->addRoute('GET', '/users/get/{id}', 'UserController', 'getById');
$router->addRoute('POST', '/users/add', 'UserController', 'create');
$router->addRoute('POST', '/users/login', 'UserController', 'login');
$router->addRoute('PUT', '/users/{id}', 'UserController', 'update');
$router->addRoute('DELETE', '/users/{id}', 'UserController', 'delete');


$requestMethod = $_SERVER["REQUEST_METHOD"];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router->handleRequest($requestMethod, $uri);
