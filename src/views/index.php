<?php
session_start();
// déconnexion user
if (!empty($_SESSION['user_id']) && $_GET['session-off']){
    // statut déconnecté
    $idUser=$_SESSION['user_id'];
    userStatusToNotConnected($pdo,$idUser);

    // destruction de la session
    session_destroy();
    session_start();

// redirection accueil si user connecté
} elseif (!empty($_SESSION['user_id'])) {
    header('Location: homepage.php');
    exit;
}

$errors=[];
$savedContent['user_login']=null;
$savedContent['login']=null;

// traitement formulaires si methode POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['sign_up'])) {
        require_once('../includes/sign_up_validation.php');
    } elseif (isset($_POST['sign_in'])){
        require_once('../includes/sign_in_validation.php');
    }
}

// bufferisation
ob_start();
require_once('views/templates/sign_up_form.php');
require_once('views/templates/sign_in_form.php');
$content=ob_get_clean();

require_once('views/templates/base_layout.php');
