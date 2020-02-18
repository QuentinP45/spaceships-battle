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

$vaisseauAdverse=null;
$vaisseauUser=null;
if (!empty($_GET['fight'])){
    $idJoueurAdverse=(int)test_input($_GET['fight']);

    $vaisseauxAdversesDispos=getOpponentReadySpaceships($pdo, $idJoueurAdverse);
    // min 1 vaisseau disponible
    if (count($vaisseauxAdversesDispos)!=0){
        // 1 vaisseau disponible
        if (count($vaisseauxAdversesDispos)==1){
            $vaisseauAdverse=$vaisseauxAdversesDispos[0];
        // plus d'un vaisseau disponible
        } else {
            shuffle($vaisseauxAdversesDispos);
            $vaisseauAdverse=$vaisseauxAdversesDispos[0];
        }
        
        $vaisseauxUserDispos=getUsersReadySpaceshipsInfos($pdo, $user_id);
        // min 1 vaisseau disponible
        if (count($vaisseauxUserDispos)!=0){
            // 1 vaisseau disponible
            if (count($vaisseauxUserDispos)==1){
                $vaisseauUser=$vaisseauxUserDispos[0];
            // plus d'un vaisseau disponible
            } else {
                shuffle($vaisseauxUserDispos);
                $vaisseauUser=$vaisseauxUserDispos[0];
            }
        }
    } else {
    // pas de vaisseaux adverses disponible, erreur
    }
}

// appel de View
$addNav=True;
$titre=SITE_NAME . ' : champ de bataille';

require_once('views/battleground.php');
