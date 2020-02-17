<?php
ob_start();
?>

<section id="container">
    <?php if($detailsVaisseau): ?>
    <h1>Détails du vaisseau: <?= $detailsVaisseau->nomVaisseau ?></h1>
    <div id="details-vaisseau">
        <div>
            <section>
                <h1>Statistiques du vaisseau</h1>
                <table>
                    <thead>
                        <th>Attaque</th>
                        <th>Défense</th>
                        <th>Rapidité</th>
                        <th>Solidité</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= $detailsVaisseau->attaque ?></td>
                            <td><?= $detailsVaisseau->defense ?></td>
                            <td><?= $detailsVaisseau->rapidite ?></td>
                            <td><?= $detailsVaisseau->solidite ?></td>
                        </tr>
                    </tbody>
                </table>
            </section>
            <section>
                <h1>Type du vaisseau</h1>
                <p>Vaisseau de type: <?= $detailsVaisseau->nomType ?></p>
                <p><?= $detailsVaisseau->detail ?></p>
            </section>
        </div>
        <div>
            <img src="<?=$detailsVaisseau->lienImage?>" alt="">
        </div>
    </div>
    <?php else: ?>
    <h1>Pas de vaisseau correspondant !</h1>
    <?php endif ?>
</section>
<?php
$content=ob_get_clean();

require_once('views/templates/base_layout.php');