<?php
ob_start();
?>
<section id="container">
    <h1><?=$titre?></h1>
    <section>
        <section>
            <h2>Vaisseaux en stocks</h2>
            <div id="shop-spaceships">
            <?php foreach ($vaisseauxFantomes as $vaisseauFantome): ?>
                <section class="relative">
                    <h3><?= $vaisseauFantome->nomVaisseau ?></h3>
                <!-- vaisseau non possédé par USER et disponible à l'achat -->
                <?php if (!in_array($vaisseauFantome->idVaisseau,$vaisseauxPossedes) && in_array($vaisseauFantome->idVaisseau,$vaisseauxDisponibleAchat)): ?>
                    <img src="<?= $vaisseauFantome->lienImage ?>" alt="" width="300px">
                    <form action="" method="POST">
                        <input type="hidden" name="vaisseau_choisi" value="<?= $vaisseauFantome->idVaisseau ?>">
                        <input type="submit" name="achat_vaisseau" value="Acheter">
                    </form>
                <!-- vaisseau possédé par USER -->
                <?php elseif (in_array($vaisseauFantome->idVaisseau,$vaisseauxPossedes)): ?>
                    <img src="<?= $vaisseauFantome->lienImage ?>" class="owned" alt="" width="300px"></a>
                    <p class="absolute">Possédé</p>
                <?php else: ?>
                <!-- vaisseau indisponible à l'achat -->
                    <img src="<?= $vaisseauFantome->lienImage ?>" class="unavailable" alt="" width="300px"></a>
                    <p class="absolute">A débloquer</p>
                <?php endif ?>
                    <p>Niveau: <?= $vaisseauFantome->niveau ?></p>
                    <p>Prix: <?= $vaisseauFantome->prix ?></p>
                    <a href="details.php?id=<?=$vaisseauFantome->idVaisseau?>">
                        <button>Détails</button>
                    </a>
                </section>
            <?php endforeach ?>
            </div>
        </section>
    </section>
</section>

<?php
$content=ob_get_clean();

require_once('views/templates/base_layout.php');
