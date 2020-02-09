<?php

// appel Model
require_once('../includes/connect_base.php');
require_once('../includes/constants.php');
require_once('../includes/functions.php');

session_start();
if (!empty($_SESSION['user_id'])) {
    $user_id=$_SESSION['user_id'];
} else {
    header('Location: index.php?page=index');
    exit;
}

// récupère les vaisseaux fantômes de USER avec tableau des vaisseaux possédés et tableau des vaisseaux non disponibles à l'achat
$vaisseaux=getAllSpaceshipsFromUsersSpaceships($pdo,$user_id);
$vaisseauxFantomes=[];
$vaisseauxPossedes=[];
$vaisseauxDisponibleAchat=[];
foreach ($vaisseaux as $vaisseau){
    $vaisseauxFantomes[$vaisseau->idVaisseau]=$vaisseau;
    if ($vaisseau->possede){
        $vaisseauxPossedes[]=$vaisseau->idVaisseau;
    }
    if ($vaisseau->disponibleAchat){
        $vaisseauxDisponibleAchat[]=$vaisseau->idVaisseau;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['vaisseau_choisi'])) {
        $vaisseauChoisi = test_input($_POST['vaisseau_choisi']);

        // USER ne possède pas le vaisseau choisi
        if (!in_array($vaisseauChoisi,$vaisseauxPossedes)) {
            // argent USER
            $argentJoueur=getUserGold($pdo, $user_id);

            $niveauVaisseauChoisi=$vaisseauxFantomes[$vaisseauChoisi]->niveau;
            $prixVaisseauChoisi=$vaisseauxFantomes[$vaisseauChoisi]->prix;
            
            // user peut acheter le vaisseau
            if ($prixVaisseauChoisi <= $argentJoueur) {
                $reste=$argentJoueur - $prixVaisseauChoisi;
                
                buySpaceship($pdo, $user_id, $vaisseauChoisi);

                // ajout vaisseau choisi dans les vaisseaux possédés
                $vaisseauxPossedes[] = $vaisseauChoisi;

                // débit USER : argent - prix vaiseau choisi
                setGold($pdo, $reste, $user_id);

                // rend les x vaisseaux du même niveau non choisis indisponibles à l'achat
                setSpaceshipsUnavailableToBuy($pdo, $user_id, $vaisseauChoisi, $niveauVaisseauChoisi);

                header('Location: index.php?page=shop');
            }
        }        
    }
}

$addNav=true;
$titre=SITE_NAME . ' : shop';

// appel de View
$link='<link rel="stylesheet" href="../assets/css/shop.css">';
$addNav=True;
$titre=SITE_NAME . ' : shop';

require_once('views/shop.php');