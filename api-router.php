<?php
require_once './libs/Router.php';
require_once './app/controllers/cliente.controller.php';

// crea el router
$router = new Router();

// defina la tabla de ruteo
/*
$router->addRoute("clientes", 'GET', ApiController::class, 'getExpenses');
$router->addRoute("clientes/:id", 'GET', ApiController::class, 'getExpense');
$router->addRoute("clientes/:id", 'DELETE', ApiController::class, 'deleteExpense');
$router->addRoute("clientes/:id", 'PUT', ApiController::class, 'putExpense');
$router->addRoute("clientes", 'POST', ApiController::class, 'addExpense');
*/
$router->addRoute('clientes', 'GET', 'ControllerCliente', 'get');
$router->addRoute('clientes/:id', 'GET', 'ControllerCliente', 'getPorId');
$router->addRoute('clientes/:id', 'PUT', 'ControllerCliente', 'put');
$router->addRoute('clientes/:id', 'DELETE', 'ControllerCliente', 'delete'); 
$router->addRoute('clientes', 'POST', 'ControllerCliente', 'post');

// ejecuta la ruta (sea cual sea)
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);