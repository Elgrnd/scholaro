<div class="marge">
    <div>
        <h1>Filtre :</h1>
        <form method=<?php if (\App\Sae\Configuration\ConfigurationSite::getDebug()) echo "get"; else echo "post" ?> action="?">
            <?php
            foreach ((new \App\Sae\Modele\Repository\AgregationRepository())->recuperer() as $agregation){
                $check = "";
                if (!empty($agregations)){
                    if (in_array($agregation, $agregations)){
                        $check = "checked";
                    }
                }
                echo "<input type=checkbox name='idAgregations[]' value='".$agregation->getIdAgregation()."' id='".$agregation->getIdAgregation()."' ".$check.">
                <label for='".htmlspecialchars($agregation->getIdAgregation())."' > ".htmlspecialchars($agregation->getNomAgregation())." </label> 
            ";
            }
            ?>
            <input type='hidden' name='action' value='afficherListeFiltre'>
            <input type="hidden" name="controleur" value="etudiant">
            <input type="submit" name="valider" value="Valider">
        </form>
    </div>

    <div class="titre">
        <div class="table-title">
            <h1 >Liste Etudiant</h1>
        </div>
        <div class="bouton-importation">
            <form action="controleurFrontal.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="controleur" value="etudiant">
                <input type="hidden" name="action" value="ajouterDepuisCSV">
                <div>
                    <input type="file" id="file" name="file" accept=".csv" style="display: none;" onchange="this.form.submit()">
                    <label for="file" >
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
            <?php /** @var \App\Sae\Modele\DataObject\Agregation $agregations*/
            if (!empty($agregations)) {
                $actionTexte = "";
                foreach ($agregations as $agregation) {
                    $actionTexte .= "&idAgregations%5B%5D=".$agregation->getIdAgregation();
                }
                foreach ($agregations as $agregation) {
                    echo '<th>' . htmlspecialchars($agregation->getNomAgregation()) .
                        '<a href="?controleur=etudiant&action=triDecroissant&idAgregation=' . $agregation->getIdAgregation() . $actionTexte.'"> ⬆️ </a>
                    <a href="?controleur=etudiant&action=triCroissant&idAgregation=' . $agregation->getIdAgregation() . $actionTexte.'">⬇️</a> </th>';
                }

            }?>
            <th>Avis</th>
        </tr>
        </thead>


    <tbody>
    <?php
    /**
     * @var \App\Sae\Modele\DataObject\Etudiant[] $etudiants
     * @var \App\Sae\Modele\DataObject\Agregation[] $agregations
     */


    foreach ($etudiants as $etudiant) {
        $etudiantAvis = $etudiant->getAvis();
        if ($etudiantAvis == "") {
            $etudiantAvis = "Pas d'avis";
        }
        echo '
       <tr>
        <td> <a href="?controleur=etudiant&action=afficherEtudiantPage&idEtudiant='.$etudiant->getEtudid().'">'. $etudiant->getEtudid() . '</a></td>
        <td> <a href="?controleur=etudiant&action=afficherEtudiantPage&idEtudiant='.$etudiant->getEtudid().'">' . htmlspecialchars($etudiant->getNomEtu()) . '</a> </td> 
        <td> <a href="?controleur=etudiant&action=afficherEtudiantPage&idEtudiant='.$etudiant->getEtudid().'">' . htmlspecialchars($etudiant->getPrenomEtu()) . '</a></td>
        
        
        ';
        if (!empty($agregations)) {
            foreach ($agregations as $agregation) {
                echo '<td> <a href="?controleur=etudiant&action=afficherEtudiantPage&idEtudiant=' . $etudiant->getEtudid() . '">' . (new \App\Sae\Modele\Repository\EtudiantRepository())->getNoteEtudiantAgregation($etudiant->getEtudid(), $agregation->getIdAgregation()) . '</a></td>';
            }
        }
        echo '<td> <a href="?controleur=etudiant&action=afficherEtudiantPage&idEtudiant='.$etudiant->getEtudid().'">' . htmlspecialchars($etudiantAvis) . '</a></td>
                </tr>';
    }


    ?>
    </tbody>
    </table>
        <?php
        if (empty($etudiants)){
            echo '<h3 class="pas-etudiant">Il n\'y a aucun étudiant, veuillez en importer</h3>';
        } ?>
</div>

