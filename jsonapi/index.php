<?php

spl_autoload_register(function ($classRequired) {
    require_once('../' . str_replace("\\", "/", $classRequired) . '.php');
});

$router = new Routing\Router();
$router->processRequest();
