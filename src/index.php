<?php
// routing
require_once('../includes/functions.php');

$pages=['index','accueil'];

$page='index';
if (!empty($_GET['page'])) {
    $param=test_input($_GET['page']);
    if (in_array($param,$pages)) {
        $page=$param;
    }
}

switch($page){
    case 'index':
        require_once('controllers/indexController.php');
        break;
    case 'accueil':
        require_once('controllers/homepageController.php');
        break;
}