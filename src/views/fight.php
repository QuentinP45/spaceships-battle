<?php
ob_start();
?>
<section id="container">
    <h1>Combats</h1>
    <section>
        <h2>Joueurs prêts pour le combat</h2>
        <?php if (!$userEstDispo): ?>
        <p>Vous n'avez pas de vaisseau disponible pour le combat !<br>
        Modifiez l'activité d'un vaisseau sur votre page d'accueil pour affronter un joueur !</p>
        <?php endif ?>
        <div id="available-players">
        <?php foreach($joueursDisponibles as $joueur):?>
            <section>
                <h2><?=$joueur->loginJoueur?></h2>
                <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fkooledge.com%2Fassets%2Fdefault_medium_avatar-57d58da4fc778fbd688dcbc4cbc47e14ac79839a9801187e42a796cbd6569847.png&f=1&nofb=1" alt="">
                <p>Niveau: <?=$joueur->niveau?></p>
                <?php if ($userEstDispo): ?>
                <form action="/spaceships-battle/src/index.php" method="GET">
                    <input type="hidden" name="page" value="champ-de-bataille">
                    <button type="input" name="fight" value="<?=$joueur->idJoueur?>">Affronter</button>
                </form>
                <?php endif ?>
            </section>
        <?php endforeach?>
        </div>
    </section>
</section>
<?php
$content=ob_get_clean();

require_once('views/templates/base_layout.php');