<?php
session_start();
if (!empty($_SESSION['user_id'])) {
    $user_id=$_SESSION['user_id'];
    $user_login=$_SESSION['user_login'];
} else {
    header('Location: index.php');
    exit;
}

require_once('../includes/functions.php');
include_once('../includes/constants.php');
require_once('../includes/connect_base.php');

$userEstDispo=getUserSpaceShipsReadyForBattle($pdo, $user_id);

$joueursDisponibles= getReadyOpponents($pdo, $user_id);

$addNav=true;
$titre=SITE_NAME . ' : shop';

// appel de View
$link='<link rel="stylesheet" href="../assets/css/fight.css">';
$addNav=True;
$titre=SITE_NAME . ' : combats';

require_once('views/fight.php');