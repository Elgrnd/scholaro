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
    <link rel="stylesheet" href="../ressources/css/vueGeneraleStyle.css" />
    <link href="../ressources/css/<?= str_replace(".php", "Style.css", $cheminCorpsVue)?>" rel="stylesheet">
</head>
<body>
<header>

    <nav class="navbar">
        <img class="logo" src="../ressources/images/logo_IUT.png" alt="logo" />
        <div class="nav_links">
            <ul>
                <li>
                    <a href="controleurFrontal.php?action=afficherListe">ACCUEIL</a>
                </li>
                <li>
                    <a href="controleurFrontal.php?action=afficherListe">LISTE</a>
                </li>
                <li>
                    <a href="#"><img class="logout" src="../ressources/images/logout.png" alt="se déconnecter"/></a>
                </li>
            </ul>
        </div>
    </nav>

</header>
<main>
    <?php


    require __DIR__ . "/{$cheminCorpsVue}";
    ?>
</main>
<footer>
    <div class="footer-container">
        <p class="co"> Copyright © 2024 All rights reserved </p>
    </div>
</footer>
</body>
</html>

