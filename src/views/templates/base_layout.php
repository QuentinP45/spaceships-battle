<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= SITE_NAME ?>: Accueil</title>
    <link rel="stylesheet" href="../assets/css/main.css">
    <?php if (isset($link)) { echo $link; } ?>
</head>
<body>
    <?php if ($addNav) { require_once('templates/_nav.html'); } ?>
    <?=$content?>
</body>
</html>
