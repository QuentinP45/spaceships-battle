<?php
session_start();
if (!empty($_SESSION['user_id'])) {
    $user_login=$_SESSION['user_login'];
    $user_id=$_SESSION['user_id'];
} else {
    header('Location: index.php');
    exit;
}

include_once('../includes/constants.php');
require_once('../includes/functions.php');
require_once('../includes/connect_base.php');

$erreur=[];
if ($_SERVER['REQUEST_METHOD']=='POST'){
    if (!empty($_POST['submit'])){
        $submit=test_input($_POST['submit']);
        
        // traitement modification login
        if ($submit=="replace_login"){
            if (!empty($_POST['new_login'])){
                $newLogin=test_input($_POST['new_login']);
                // nouveau login entre 5 et 30 caractères
                if (mb_strlen($newLogin) >= 5 && mb_strlen($newLogin) <= 30){
                    replaceLogin($pdo, $newLogin, $user_id);

                    $_SESSION['user_login']=$newLogin;
                    $user_login=$newLogin;
                } else {
                // login trop long ou trop court
                $erreur['longueur']='Le login doit comprendre de 5 à 30 caractères';
                }
            } else {
            // champ nouveau login vide
            $erreur['champ_vide']='Remplir le champ pour modifier le login';
            }
        } // traitement modification login
        elseif ($submit=="replace_pass"){
            if (!empty($_POST['new_pass'])){
                $newPass=test_input($_POST['new_pass']);
                // nouveau pass entre 7 et 15 caractères
                if (mb_strlen($newPass) >= 7 && mb_strlen($newPass) <= 15){
                    $passwordHash=password_hash($newPass, PASSWORD_DEFAULT, ['cost' => 12]);

                    $sql=
                        'UPDATE joueurs 
                        SET motPasse=:new_pass
                        WHERE idJoueur=:id_joueur';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':new_pass', $passwordHash);
                    $stmt->bindParam(':id_joueur', $user_id);
                    $stmt->execute();
                    replacePassword($pdo, $passwordHash, $user_id);
                } else {
                // pass trop long ou trop court
                $erreur['longueur_pass']='Le mot de passe doit comprendre de 7 à 15 caractères';
                }
            } else {
            // champ nouveau pass vide
            $erreur['champ_vide_pass']='Remplir le champ pour modifier le mot de passe';
            }
        }
    }
}
// appel de View
$addNav=True;
$titre=SITE_NAME . ' : paramètres';

require_once('views/parameters.php');
?>