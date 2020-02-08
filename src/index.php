<?php
// routing
$request=$_SERVER['REQUEST_URI'];

$explodedUri=explode('/',$request);
$requestedController=array_pop($explodedUri);

switch($requestedController){
    case '':
        require_once(__DIR__ . '/controllers/indexController.php');
        break;
    case 'index.php':
        require_once(__DIR__ . '/controllers/indexController.php');
        break;
    case 'index.php?session-off=1':
        require_once(__DIR__ . '/controllers/indexController.php');
        break;
    case 'homepage.php':
        require_once(__DIR__ . '/controllers/homepageController.php');
        break;
}