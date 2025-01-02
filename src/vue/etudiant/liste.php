<div class="marge">
    <div class="Filtre">
        <h1>Filtre :</h1>
        <!-- Affichage des différents filtres disponibles -->
        <form class = "filtres" method=<?php

        use App\Sae\Configuration\ConfigurationSite;
        use App\Sae\Lib\Preferences;
        use App\Sae\Modele\Repository\AgregationRepository;

        if (ConfigurationSite::getDebug()) echo "get"; else echo "post" ?> action="controleurFrontal.php">
            <?php
            foreach ((new AgregationRepository())->recuperer() as $agregation) {
                $idAgregation = $agregation->getIdAgregation();
                $nomAgregationHtml = htmlspecialchars($agregation->getNomAgregation());
                if (in_array($idAgregation, Preferences::lire("choixFiltres"))) {
                    echo "<input type=checkbox name='idAgregations$idAgregation' value='" . $idAgregation . "' id='" . $idAgregation . "' checked onchange='this.form.submit()'>
                <label for='" . $idAgregation . "' > " . $nomAgregationHtml . " </label>";
                } else {
                    echo "<input type=checkbox name='idAgregations$idAgregation' value='" . $idAgregation . "' id='" . $idAgregation . "' onchange='this.form.submit()'>
                <label for='" . $idAgregation . "' > " . $nomAgregationHtml . " </label> 
            ";
                }
            }
            ?>
            <input type='hidden' name='action' value='enregistrerFiltres'>
            <input type="hidden" name="controleur" value="etudiant">
        </form>
    </div>

    <!-- Affichage du Titre de la page ainsi que le bouton d'importation -->
    <div class="titre">
        <div class="table-title">
            <h1>Liste Etudiant</h1>
        </div>
        <div class="bouton-importation">
            <form action="controleurFrontal.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="controleur" value="etudiant">
                <input type="hidden" name="action" value="ajouterDepuisCSV">
                <div>
                    <input type="file" id="file" name="file" accept=".csv" style="display: none;"
                           onchange="this.form.submit()">
                    <label for="file">
                        Importer Etudiant (.csv)
                    </label>
                </div>
            </form>

        </div>
    </div>

    <!-- Affichage du Tableau contenant la liste des étudiants -->
    <table>
        <thead>
        <tr>
            <th>Id Etudiant</th>
            <th>Nom</th>
            <th>Prenom</th>
            <?php /** @var \App\Sae\Modele\DataObject\Agregation $agregations */
            if (!empty($agregations)) {
                foreach ($agregations as $agregation) {
                    if (!$agregation) {
                        continue;
                    }
                    $idAgregation = $agregation->getIdAgregation();
                    echo '<th>' . htmlspecialchars($agregation->getNomAgregation()) .
                        '<a href="?controleur=etudiant&action=triDecroissant&idAgregation=' . $idAgregation .'"> <img class="fleche" src="../ressources/images/fleche_haut.png" alt="fleche_haut"> </a>
                    <a href="?controleur=etudiant&action=triCroissant&idAgregation=' . $idAgregation .'"><img class="fleche" src="../ressources/images/fleche_bas.png" alt="fleche_bas"></a> </th>';
                }

            } ?>

        </tr>
        </thead>


        <tbody>
        <?php
        /**
         * @var \App\Sae\Modele\DataObject\Etudiant[] $etudiants
         * @var \App\Sae\Modele\DataObject\Agregation[] $agregations
         */


    foreach ($etudiants as $etudiant) {
        $idEtudiant = $etudiant->getEtudid();
        echo '
       <tr>
        <td> <a href="?controleur=etudiant&action=afficherEtudiantPage&regarder=admin&idEtudiant='.$idEtudiant.'">'. $idEtudiant . '</a></td>
        <td> <a href="?controleur=etudiant&action=afficherEtudiantPage&regarder=admin&idEtudiant='.$idEtudiant.'">' . htmlspecialchars($etudiant->getNomEtu()) . '</a> </td> 
        <td> <a href="?controleur=etudiant&action=afficherEtudiantPage&regarder=admin&idEtudiant='.$idEtudiant.'">' . htmlspecialchars($etudiant->getPrenomEtu()) . '</a></td>
        
        
        ';
        if (!empty($agregations)) {
            foreach ($agregations as $agregation) {
                if (!$agregation) {
                    continue;
                }
                echo '<td> <a href="?controleur=etudiant&action=afficherEtudiantPage&regarder=admin&idEtudiant=' . $etudiant->getEtudid() . '">' . (new \App\Sae\Modele\Repository\EtudiantRepository())->getNoteEtudiantAgregation($etudiant->getEtudid(), $agregation->getIdAgregation()) . '</a></td>';
            }
        }
        echo '</tr>';
    }


        ?>
        </tbody>
    </table>
    <?php
    if (empty($etudiants)) {
        echo '<h3 class="pas-etudiant">Il n\'y a aucun étudiant, veuillez en importer</h3>';
    } ?>
</div>

