<?php
require('../includes/connect_infos.php');

/* Connexion à une base MySQL avec l'invocation de pilote */
try {
    $pdo = new PDO(DSN, USER, PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
}

// table joueurs
function getUserId(PDO $pdo,string $loginJoueur) :int
{
    $sql=
        'SELECT idJoueur
        FROM joueurs
        WHERE loginJoueur=:1'
        ;
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':1',$loginJoueur);
    $stmt->execute();
    $joueur=$stmt->fetch(PDO::FETCH_OBJ);

    return $joueur->idJoueur;
}

function checkPassAndStatus(PDO $pdo, string $loginJoueur)
{
    $sql=
        'SELECT motPasse, estConnecte 
        FROM joueurs 
        WHERE loginJoueur=:loginJoueur'
    ;
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':loginJoueur', $loginJoueur);
    $stmt->execute();
    $joueurResults=$stmt->fetch(PDO::FETCH_OBJ);

    return $joueurResults;
}

function userStatusToNotConnected(PDO $pdo, int $idJoueur) :bool
{
    $sql=
        'UPDATE joueurs
        SET estConnecte=0
        WHERE idJoueur=:idJoueur'
    ;
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':idJoueur',$idJoueur);

    return $stmt->execute();
}

function userStatusToConnected(PDO $pdo, string $loginJoueur) :bool
{
    $sql=
        'UPDATE joueurs
        SET estConnecte=1
        WHERE loginJoueur=:loginJoueur'
    ;
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':loginJoueur',$loginJoueur);

    return $stmt->execute();
}

// table vaisseaux
function getSpaceShips(PDO $pdo) :array
{
    $sql=
        'SELECT idVaisseau, nomVaisseau 
        FROM vaisseaux'
    ;
    $stmt = $pdo->query($sql);
    $stmt->execute();
    $vaisseaux=$stmt->fetchAll(PDO::FETCH_OBJ);

    return $vaisseaux;
}

// fonctions specifique index
function userRegistration(PDO $pdo,string $userLogin,string $passwordHash) :bool
{
    $sql=
        'INSERT INTO joueurs (loginJoueur, motPasse) 
        VALUES (:name, :value)'
    ;
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $userLogin);
    $stmt->bindParam(':value', $passwordHash);

    return $stmt->execute();
}

function fillUserDefaultSpaceships(PDO $pdo,array $vaisseaux, $idJoueur) :bool
{
    $sql=
        'INSERT INTO joueurs_vaisseaux (idJoueur,idVaisseau) 
        VALUES (:1,:2)'
    ;
    $stmt=$pdo->prepare($sql);
    $requestStatus=false;
    foreach ($vaisseaux as $vaisseau){
        $idVaisseau = $vaisseau->idVaisseau;
        $stmt->bindParam(':1',$idJoueur);
        $stmt->bindParam(':2',$idVaisseau);
        $requestStatus=$stmt->execute();
    }

    return $requestStatus;
}
