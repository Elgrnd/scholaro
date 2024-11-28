
<div class="detail content">
    <h1>
        Généralités
    </h1>
    <?php
    /**
     * @var \App\Sae\Modele\DataObject\Etudiant $etudiant
     * @var \App\Sae\Modele\DataObject\Ecole[] $ecolesChoisie
     * @var string $regarder
     * @var string[][] $avis
     */

    $nomEtudiant = htmlspecialchars($etudiant->getNomEtu());
    $prenomEtudiant = htmlspecialchars($etudiant->getPrenomEtu());
    $civ = htmlspecialchars($etudiant->getCiv());
    $bac = htmlspecialchars($etudiant->getBac());
    $spe = htmlspecialchars($etudiant->getSpecialite());
    $codeNip = htmlspecialchars($etudiant->getCodenip());


    ?>

    <p> Code Nip : <?=$codeNip?></p>
    <p> Nom : <?=$nomEtudiant?> </p>
    <p> Prénom : <?=$prenomEtudiant?> </p>
    <p> Civilité : <?=$civ?> </p>
    <p> Baccalauréat : <?=$bac?> </p>
    <p> Spécialité : <?=$spe?> </p>


    <?php
    $methode = "";
    $action = "";
    if ($regarder == "admin") $action = "ajouterAvis"; else $action = "ajouterEcoleFavoris";
    if (\App\Sae\Configuration\ConfigurationSite::getDebug()) $methode = "get"; else $methode = "post";

        if ($regarder == "admin"){
            if (!empty($ecolesChoisie)){
                echo '<h1>Ecole Favorite</h1>
                <form method="'. $methode .'" action="?">
               ';
                foreach ($ecolesChoisie as $ecole) {
                    $TFselected = "";
                    $Fselected = "";
                    $Rselected = "";
                    $commentaire = "";
                    if (!empty($avis)){
                        if ($avis[$ecole->getIdEcole()][0] == "Tres-Favorable"){
                            $TFselected = "selected";
                        } else if ($avis[$ecole->getIdEcole()][0] == "Favorable"){
                            $Fselected = "selected";
                        } else if ($avis[$ecole->getIdEcole()][0] == "Reserve"){
                            $Rselected = "selected";
                        }
                        if (!empty($avis[$ecole->getIdEcole()][1])){
                            $commentaire = $avis[$ecole->getIdEcole()][1];
                        }
                    }

                    $ecolesChoisieNom = htmlspecialchars($ecole->getNomEcole());
                    $ecolesChoisieVille = htmlspecialchars($ecole->getVilleEcole());
                    echo '<div><label for="'. $ecole->getIdEcole() . '">'. $ecolesChoisieNom . ' -> ' . $ecolesChoisieVille . '</label>' .
                        '<select name="avisEcoles[]" id="'.$ecole->getIdEcole().'">
                            <option value="Tres-Favorable_'.$ecole->getIdEcole().'" '.$TFselected.'>Très Favorable</option>
                            <option value="Favorable_'.$ecole->getIdEcole().'" '. $Fselected.'>Favorable</option>
                            <option value="Reserve_'.$ecole->getIdEcole().'" '. $Rselected.'>Réservé</option>
                        </select>
                        </div>
                        <div>
                        <label for="commentaire">Commentaire :</label><br>
                        <textarea id="commentaire" name="commentaires['.$ecole->getIdEcole().']" rows="5" cols="40" style="border: 2px solid black; padding: 5px;">'.htmlspecialchars($commentaire).'</textarea>
                        </div>';
                }
                echo '<input type="hidden" name="idEtudiant" value="'.$etudiant->getEtudid().'">
                <input type="hidden" name="action" value="'.$action.'">
                <input type="hidden" name="controleur" value="etudiant">
                <input type="hidden" name="regarder" value="admin">
                <input type="submit" name="valider" value="Valider">
                </form>';
            }
        } else {
            echo '<h1>Ecole Favorite</h1>
            <form method="'. $methode .'" action="?">
           ';
            foreach ((new \App\Sae\Modele\Repository\EcoleRepestory())->recuperer() as $ecole) {
                $check = "";
                if (!empty($ecolesChoisie)){
                    if (in_array($ecole, $ecolesChoisie)){
                        $check = "checked";
                    }
                }
                echo '<input type="hidden" name="idEcoles[]" value="'.$ecole->getIdEcole().'False">
                <input type="checkbox" name="idEcoles[]" value="'.$ecole->getIdEcole().'" id="'.$ecole->getIdEcole().'" '. $check .'>
        <label for="'.$ecole->getIdEcole().'">'.htmlspecialchars($ecole->getNomEcole()).'</label>
        ';
            }
            echo '<input type="hidden" name="idEtudiant" value="'.$etudiant->getEtudid().'">
                <input type="hidden" name="action" value="'.$action.'">
                <input type="hidden" name="controleur" value="etudiant">
                <input type="submit" name="valider" value="Valider">
                </form>';
        }
    ?>

</div>
<div class="content">
    <h1>
        Notes
    </h1>
    <?php

    /**
     *@var $notesAgregees \App\Sae\Modele\DataObject\Agregation[]
     */

    $idEtu = $etudiant->getEtudid();
    if (!empty($notes)) {
        $id = 0;
        foreach ($notes as $note) {
            echo "<p>$note[2] : $note[3] </p>";
            $id+= 1;
        }
    } else {
        echo "<p> L'étudiant n'a pas de notes</p>";
    }

    if($etudiant->getAvis() != null) {
        echo '<p> Avis </p>';
        echo '<p>' . htmlspecialchars($etudiant->getAvis()) . ' </p>';
    }
    ?>
</div>

