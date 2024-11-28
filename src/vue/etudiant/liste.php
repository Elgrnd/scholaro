<div class="marge">
    <div>
        <h1>Filtre :</h1>
        <form method=<?php use App\Sae\Configuration\ConfigurationSite;
        use App\Sae\Lib\Preferences;
        use App\Sae\Modele\Repository\AgregationRepository;

        if (ConfigurationSite::getDebug()) echo "get"; else echo "post" ?> action="controleurFrontal.php">
            <?php
            foreach ((new AgregationRepository())->recuperer() as $agregation) {
                $id = $agregation->getIdAgregation();
                if (in_array($agregation->getIdAgregation(), Preferences::lire("choixFiltres"))) {
                    echo "<input type=checkbox name='idAgregations$id' value='" . $agregation->getIdAgregation() . "' id='" . $agregation->getIdAgregation() . "' checked onchange='this.form.submit()'>
                <label for='" . $agregation->getIdAgregation() . "' > " . $agregation->getNomAgregation() . " </label>";
                } else {
                    echo "<input type=checkbox name='idAgregations$id' value='" . $agregation->getIdAgregation() . "' id='" . $agregation->getIdAgregation() . "' onchange='this.form.submit()'>
                <label for='" . $agregation->getIdAgregation() . "' > " . $agregation->getNomAgregation() . " </label> 
            ";
                }

            }
            ?>
            <input type='hidden' name='action' value='enregistrerFiltres'>
            <input type="hidden" name="controleur" value="etudiant">
        </form>
    </div>

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

    <table>
        <thead>
        <tr>
            <th>Id Etudiant</th>
            <th>Nom</th>
            <th>Prenom</th>
            <?php /** @var \App\Sae\Modele\DataObject\Agregation $agregations */
            if (!empty($agregations)) {
                foreach ($agregations as $agregation) {
                    echo '<th>' . $agregation->getNomAgregation() .
                        '<a href="?controleur=etudiant&action=triDecroissant&idAgregation=' . $agregation->getIdAgregation() .'"> ⬆️ </a>
                    <a href="?controleur=etudiant&action=triCroissant&idAgregation=' . $agregation->getIdAgregation() .'">⬇️</a> </th>';
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
        echo '
       <tr>
        <td> <a href="?controleur=etudiant&action=afficherEtudiantPage&regarder=admin&idEtudiant='.$etudiant->getEtudid().'">'. $etudiant->getEtudid() . '</a></td>
        <td> <a href="?controleur=etudiant&action=afficherEtudiantPage&regarder=admin&idEtudiant='.$etudiant->getEtudid().'">' . htmlspecialchars($etudiant->getNomEtu()) . '</a> </td> 
        <td> <a href="?controleur=etudiant&action=afficherEtudiantPage&regarder=admin&idEtudiant='.$etudiant->getEtudid().'">' . htmlspecialchars($etudiant->getPrenomEtu()) . '</a></td>
        
        
        ';
        if (!empty($agregations)) {
            foreach ($agregations as $agregation) {
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

