<?php
$password=null;
$login=null;
if (!empty($_POST['login'])) {
    $login = test_input($_POST['login']);
    $savedContent['login']=$login;
} else {
    // champ login vide
    $errors['login'] = 'Saisir votre identifiant';
}
if (!empty($_POST['password'])) {
    $password = test_input($_POST['password']);
    if ($login==null) {
        $errors['password'] = 'Saisir votre mot de passe';
    }
} else {
    // champ password vide
    $errors['password'] = 'Saisir votre mot de passe';
}

if (count($errors) == 0) {
    $userResults=checkPassAndStatus($pdo, $login);
    $passwordHash='';
    if ($userResults) {
        $passwordHash=$userResults->motPasse;
    } 
    if (!empty($passwordHash)) {
        if (password_verify($password,$passwordHash)) {
            if ($userResults->estConnecte) {
                $errors['connected']="Le joueur $login est déjà connecté";
            } else {
                userStatusToConnected($pdo, $login);
            
                $_SESSION['user_login']=$login;
                
                // récupère idJoueur
                $idUser=getUserId($pdo, $login);
                
                $_SESSION['user_id']=$idUser;
                
                // redirection page personnelle
                header('Location: homepage.php');
                exit;
            }
        } else {
            $errors['password']='Mot de passe incorrect';
        }
    } else {
        $errors['login']='Login incorrect';
    }
        
}