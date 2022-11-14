<?php
    require_once "libs\Router.php";
    require_once "app/controllers/FinanceApiController.php";

    $router = new Router();

    $router -> addRoute('company', 'GET', 'FinanceApiController', 'showCompanies');
    $router -> addRoute('company/:ID', 'GET', 'FinanceApiController', 'showCompany');
    $router -> addRoute('company/:ID', 'DELETE', 'FinanceApiController', 'deleteCompany');
    $router -> addRoute('company', 'POST', 'FinanceApiController', 'addCompany');
    $router -> addRoute('company/:ID', 'PUT', 'FinanceApiController', 'updateCompany');



    $router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);
