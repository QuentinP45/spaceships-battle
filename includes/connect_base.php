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

function getUserGold(PDO $pdo, int $userId) :int
{
    $sql=
        'SELECT joueurs.argent 
        FROM joueurs  
        WHERE joueurs.idJoueur = :userId'
        ;
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':userId',$userId);
    $stmt->execute();
    $argentJoueur=$stmt->fetch(PDO::FETCH_OBJ)->argent;

    return $argentJoueur;
}

function setGold(PDO $pdo, int $reste, int $userId) :bool
{
    $sql=
        'UPDATE `joueurs`
        SET `argent` = :1
        WHERE `idJoueur` = :2'
        ;
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':1',$reste,PDO::PARAM_INT);
    $stmt->bindParam(':2',$userId);

     return $stmt->execute();
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

function getStatsUser(PDO $pdo, string $userLogin) :object
{
    $sql=
        'SELECT argent,niveau,experience,nbPointsReparation 
        FROM joueurs 
        WHERE loginJoueur=:userLogin'
    ;
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':userLogin', $userLogin);
    $stmt->execute();
    $statsJoueur=$stmt->fetch(PDO::FETCH_OBJ);

    return $statsJoueur;
}

function replaceLogin(PDO $pdo, string $newLogin, int $idUser) :bool
{
    $sql=
        'UPDATE joueurs
        SET loginJoueur=:1
        WHERE idJoueur=:2'
    ;
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':1',$newLogin);
    $stmt->bindParam(':2',$idUser);

    return $stmt->execute();
}

function replacePassword(PDO $pdo, string $passwordHash, int $idUser)
{
    $sql=
        'UPDATE joueurs 
        SET motPasse=:new_pass
        WHERE idJoueur=:id_joueur';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':new_pass', $passwordHash);
    $stmt->bindParam(':id_joueur', $idUser);
    $stmt->execute();
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

function changeSpaceshipActivityStatus(PDO $pdo, int $statut, int $idUser, int $idVaisseau) :bool
{
    $sql=
        'UPDATE joueurs_vaisseaux
        SET activite=:1
        WHERE idJoueur=:2
        AND idVaisseau=:3'
    ;
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':1',$statut);
    $stmt->bindParam(':2',$idUser);
    $stmt->bindParam(':3',$idVaisseau);
    
    return $stmt->execute();
}

function getSpaceShipsAndTypes(PDO $pdo, int $idVaisseau) :object
{
    $sql=
        'SELECT *
        FROM vaisseaux
        NATURAL JOIN types
        where idVaisseau=:id_vaisseau'
    ;
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':id_vaisseau',$idVaisseau);
    $stmt->execute();
    $detailsVaisseau=$stmt->fetch(PDO::FETCH_OBJ);

    return $detailsVaisseau;
}

// table joueurs_vaisseaux
function getUserPossessedSpaceships(PDO $pdo, int $idUser) :array
{
    $sql=
        'SELECT lienImage,joueurs_vaisseaux.idVaisseau,nomVaisseau,nomType,nbVictoires,nbDefaites,dommages,activite
        FROM joueurs_vaisseaux
            inner JOIN vaisseaux
            ON joueurs_vaisseaux.idVaisseau = vaisseaux.idVaisseau
            inner JOIN types
            ON vaisseaux.idType = types.idType
        WHERE idJoueur=:idUser
        AND possede=1'
    ;

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':idUser', $idUser);
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

// fonctions spécifiques shop
function getAllSpaceshipsFromUsersSpaceships(PDO $pdo, int $userId) :array
{
    $sql=
        'SELECT jv.idVaisseau,nomVaisseau,possede,disponibleAchat,niveau,prix,lienImage
        FROM joueurs_vaisseaux as jv
        INNER JOIN vaisseaux as v
        ON jv.idVaisseau=v.idVaisseau
        WHERE idJoueur = :1'
    ;
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':1',$userId);
    $stmt->execute();
    $vaisseaux=$stmt->fetchAll(PDO::FETCH_OBJ);
    return $vaisseaux;
}

function buySpaceship(PDO $pdo, int $userId, $vaisseauChoisi) :bool
{
    $sql=
        'UPDATE joueurs_vaisseaux
        SET possede = 1
        WHERE idJoueur = :1
        AND idVaisseau = :2'
        ;
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':1',$userId);
    $stmt->bindParam(':2',$vaisseauChoisi);
    
    return $stmt->execute();
}

function setSpaceshipsUnavailableToBuy(PDO $pdo, int $userId, int $vaisseauChoisi, int $niveauVaisseauChoisi) :bool
{
    $sql=
        'UPDATE joueurs_vaisseaux as jv
        INNER JOIN vaisseaux as v
        ON jv.idVaisseau=v.idVaisseau
        SET `disponibleAchat` = 0
        WHERE jv.idJoueur = :1
        AND jv.idVaisseau <> :2
        AND `niveau` = :3'
    ;
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':1',$userId);
    $stmt->bindParam(':2',$vaisseauChoisi);
    $stmt->bindParam(':3',$niveauVaisseauChoisi);
    
    return $stmt->execute();
}


