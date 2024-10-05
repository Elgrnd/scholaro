<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php
        /**
         * @var string $titre
         */
        echo $titre;
        /**
         * @var string $cheminCorpsVue
         */
        ?></title>
    <link href="../ressources/css/<?= str_replace(".php", "Style.css", $cheminCorpsVue)?>" rel="stylesheet">
</head>
<body>
<header>
</header>
<main>
    <?php


    require __DIR__ . "/{$cheminCorpsVue}";
    ?>
</main>
<footer>
    <p>
        Site de sae
    </p>
</footer>
</body>
</html>

