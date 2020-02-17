<?php
ob_start();
?>

<section id="container">
    <h1>Paramètres</h1>
    <section>
        <h2>Modification des paramètres utilisateurs</h2>
        <!-- modification login -->
        <section>
            <h3>Modifier le login</h3>
            <form action="" method="POST">
                <input type="text" name="new_login" placeholder="Nouveau login">
                <button type="submit" name="submit" value="replace_login">Confirmer</button>
            </form>
            <?php if(!empty($erreur['longueur'])): ?>
            <p><?=$erreur['longueur']?></p>
            <?php elseif(!empty($erreur['champ_vide'])): ?>
            <p><?=$erreur['champ_vide']?></p>
            <?php endif?>
        </section>
        <section>
            <h3>Modifier le mot de passe</h3>
            <form action="" method="POST">
                <input type="password" name="new_pass" placeholder="Nouveau mot de passe">
                <button type="submit" name="submit" value="replace_pass">Confirmer</button>
            </form>
            <?php if(!empty($erreur['longueur_pass'])): ?>
            <p><?=$erreur['longueur_pass']?></p>
            <?php elseif(!empty($erreur['champ_vide_pass'])): ?>
            <p><?=$erreur['champ_vide_pass']?></p>
            <?php endif?>
        </section>
    </section>
</section>

<?php
$content=ob_get_clean();

require_once('views/templates/base_layout.php');
