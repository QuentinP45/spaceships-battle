<?php
require_once('../includes/functions.php');
include_once('../includes/constants.php');
require_once('../includes/connect_base.php');

session_start();
if (!empty($_SESSION['user_id'])) {
    // $user_id=$_SESSION['user_id'];
    // $user_login=$_SESSION['user_login'];
} else {
    header('Location: index.php');
    exit;
}

if (!empty($_GET['id'])) {
    $idVaisseau=test_input($_GET['id']);

    $detailsVaisseau= getSpaceShipsAndTypes($pdo, $idVaisseau);

    // appel de View
    $link='<link rel="stylesheet" href="../assets/css/details.css">';
    $addNav=True;
    $titre=SITE_NAME . ' : details du vaisseau ' . $detailsVaisseau->nomVaisseau;
    require_once('views/details.php');

} else {
    header('Location: shop.php');
    exit;
}
?>


