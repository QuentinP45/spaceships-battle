<section>
    <h2>J'ai déjà un compte</h2>
    <?php if (!empty($errors['connected'])): ?>
        <div>
            <p><?=$errors['connected']?></p>
        </div>
    <?php endif ?>
    <form action="" method="POST">
        <input type="text" name="login" placeholder="JeanClaudeDuss" value="<?= !empty($savedContent['login']) ? $savedContent['login']:''; ?>">
        <?= !empty($errors['login']) ? '<p>'.$errors['login'].'</p>': null; ?>
        <?= !empty($errors['user_not_found']) ? '<p>'.$errors['user_not_found'].'</p>': null; ?>
        <input type="password" name="password">
        <?= !empty($errors['password']) ? '<p>'.$errors['password'].'</p>': null; ?>
        <input type="submit" name="sign_in" value="C'est parti">
    </form>
</section>