
<div class="detail content">
    <h1>
        Généralités
    </h1>
    <?php
    /**
     * @var \App\Sae\Modele\DataObject\Etudiant $etudiant
     * @var \App\Sae\Modele\DataObject\Ecole[] $ecolesChoisie
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



    <h1>Ecole Favorite</h1>
    <form method=<?php if (\App\Sae\Configuration\ConfigurationSite::getDebug()) echo "get"; else echo "post" ?> action="">

    <?php
    foreach ((new \App\Sae\Modele\Repository\EcoleRepository())->recuperer() as $ecole) {
        $check = "";
        if (!empty($ecolesChoisie)){
            if (in_array($ecole, $ecolesChoisie)){
                $check = "checked";
            }
        }
        echo '<input type="checkbox" name="idEcoles[]" value="'.$ecole->getIdEcole().'" id="'.$ecole->getIdEcole().'" '. $check .'>
        <label for="'.$ecole->getIdEcole().'">'.$ecole->getNomEcole().'</label>
        ';
    }
    ?>
        <input type="hidden" name="idEtudiant" value="<?=$etudiant->getEtudid()?>">
        <input type='hidden' name='action' value='ajouterEcoleFavoris'>
        <input type="hidden" name="controleur" value="etudiant">
        <input type="submit" name="valider" value="Valider">
    </form>
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
    echo "
    <form method='get' action='controleurFrontal.php'>
    <fieldset>";
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

