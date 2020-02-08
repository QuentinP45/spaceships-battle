<?php
// traitement form sign up
$userLogin=null;
if (!empty($_POST['user_login'])) {
    $userLogin = test_input($_POST['user_login']);
    // champ user_login incorrecte
    if (mb_strlen($userLogin) < 5 || mb_strlen($userLogin) > 30) {
        $errors['user_login'] = 'De 5 à 30 caractères';
    } else {
        $savedContent['user_login']=$userLogin;
    }
} else {
    // champ user_login vide
    $errors['user_login'] = 'Ne pas laisser vide';
}

if (!empty($_POST['user_password'])) {
    $userPassword = test_input($_POST['user_password']);
    // champ user_password incorrecte
    if (mb_strlen($userPassword) < 7 || mb_strlen($userPassword) > 15) {
        $errors['user_password'] = 'De 7 à 15 caractères';
    }
} else {
    // champ user_password vide
    $errors['user_password'] = 'Ne pas laisser vide';
}

// enregistrement du compte en base
if (count($errors) == 0) {

    $passwordHash=password_hash($userPassword, PASSWORD_DEFAULT, ['cost' => 12]);

    userRegistration($pdo,$userLogin,$passwordHash);

    userStatusToConnected($pdo, $userLogin);
    
    $_SESSION['user_login']=$userLogin;

    // nombre de vaisseaux en bdd
    $vaisseaux=getSpaceShips($pdo);
    $nbVaisseaux=count($vaisseaux);

    // récupère idJoueur
    $idUser=getUserId($pdo,$userLogin);
    $_SESSION['user_id']=$idUser;

    fillUserDefaultSpaceships($pdo, $vaisseaux, $idUser);

    // redirection page personnelle
    header('Location: homepage.php');
    exit;   
}