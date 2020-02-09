<?php

// appel Model
require_once('../includes/connect_base.php');
require_once('../includes/constants.php');
require_once('../includes/functions.php');

session_start();
if (!empty($_SESSION['user_id'])) {
    $user_id=$_SESSION['user_id'];
    $user_login=$_SESSION['user_login'];
} else {
    header('Location: index.php?page=index');
    exit;
}

// gestion de l'activite des vaisseaux de USER
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (!empty($_POST['activite'])){
        if (!empty($_POST['statut']) && !empty($_POST['idVaisseau'])){
            $statut= test_input($_POST['statut']);
            $idVaisseau=test_input($_POST['idVaisseau']);
            if ($statut==='actif' || $statut==='inactif'){
                if ($statut=='actif'){
                    $statut=1;
                } else {
                    $statut=0;
                }
                changeSpaceshipActivityStatus($pdo,$statut,$user_id,$idVaisseau);
            }
        }
    }
}

// requêtes page d'accueil
// statistiques jeu USER
$statsUser=getStatsUser($pdo,$user_login);

// vaisseaux possédés par user
$vaisseaux=getUserPossessedSpaceships($pdo,$user_id);

// appel de View
$link='<link rel="stylesheet" href="../assets/css/homepage.css">';
$addNav=True;
$titre=SITE_NAME . ' : accueil';
require_once('views/homepage.php');