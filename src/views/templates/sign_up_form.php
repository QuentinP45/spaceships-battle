<section>
    <h2>Je m'inscris</h2>
    <form action="" method="POST">
        <input type="text" name="user_login" placeholder="JeanClaudeDuss" value="<?= !empty($savedContent['user_login']) ? $savedContent['user_login']:''; ?>">
        <?= !empty($errors['user_login']) ? '<p>'.$errors['user_login'].'</p>': null; ?>
        <input type="password" name="user_password">
        <?= !empty($errors['user_password']) ? '<p>'.$errors['user_password'].'</p>': null; ?>
        <input type="submit" name="sign_up" value="M'inscrire">
    </form>
</section>