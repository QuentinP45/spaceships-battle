<?php
ob_start();
?>
<section id="container">
    <h1><?=$titre?></h1>
    <div>
        <section id="stats-user">
            <h2>Statistiques de jeu</h2>
            <p>Joueur: <?= $user_login ?></p>
            <p>Niveau: <?= $statsUser->niveau ?></p>
            <p>Argent: <?= $statsUser->argent ?></p>
            <p>Expérience: <?= $statsUser->experience ?></p>
            <p>Points de réparation: <?= $statsUser->nbPointsReparation ?></p>
        </section>
        <section id="new-features">
            <h2>Détail des mises à jours</h2>
            <section>
                <h3>Nouveautés</h3>
                <ul>
                    <li>Shop: Achetez votre premier vaisseau dans l'onglet acheter du menu !</li> 
                    <li>Accueil: Rendre votre nouveau vaisseau disponible pour partir en mission en modifiant son activité !</li>
                    <li>Paramètres: Modifiez votre login !</li>
                </ul>
            </section>
            <section>
                <h3>A venir</h3>
                <ul>
                    <li>Connectez vous 3 jours d'affilés pour débloquer des points de réparation supplémentaires !</li>
                    <li>Réparez votre vaisseau en échange de points de réparation !</li>
                    <li>Choisissez votre faction !</li>
                </ul>
            </section>
        </section>
    </div>
    <section id="owned-spaceships">
        <h2>Vaisseaux possédés</h2>
        <table>
            <tr>
                <th>Vaisseau</th>
                <th>Nom</th>
                <th>Type</th>
                <th>Victoires</th>
                <th>Défaites</th>
                <th>Dommages</th>
                <th>Activité</th>
            </tr>
            <?php foreach ($vaisseaux as $vaisseau): ?>
            <tr>
                <td><img src="<?= $vaisseau->lienImage ?>" width="100px"/></td>
                <td><?= $vaisseau->nomVaisseau ?></td>
                <td><?= $vaisseau->nomType ?></td>
                <td><?= $vaisseau->nbVictoires ?></td>
                <td><?= $vaisseau->nbDefaites ?></td>
                <td><?= $vaisseau->dommages ?></td>
                <td>
                    <p><?= $vaisseau->activite ?'Prêt pour le combat':'Vaisseau au repos' ?></p>
                    <form action="" method="POST">
                        <?php if ($vaisseau->activite): ?>
                        <input type="hidden" name="statut" value="inactif">
                        <input type="hidden" name="idVaisseau" value="<?=$vaisseau->idVaisseau?>">
                        <?php else: ?>
                        <input type="hidden" name="statut" value="actif">
                        <input type="hidden" name="idVaisseau" value="<?=$vaisseau->idVaisseau?>">
                        <?php endif ?>
                        <input type="submit" name="activite"  value="modifier">
                    </form>
                </td>
            </tr>
            <?php endforeach ?>
        </table>
    </section>
</section>
    

<?php
$content=ob_get_clean();
require_once('views/templates/base_layout.php'); 