<?php

//include_once 'autoload.php';
require 'Controller/Router.php';
require 'Controller/PlannerController.php';
require 'Model/Db.php';
require 'Model/Planner.php';
$params = include 'Conf/params.php';
$config = include 'Conf/database.php';


Model\Db::setConfig($config);
$url = str_replace($params['local_domain'], '', $_SERVER['REQUEST_URI']);
//echo $url;
$router = new \Controller\Router();
$router->dispatch($url);




