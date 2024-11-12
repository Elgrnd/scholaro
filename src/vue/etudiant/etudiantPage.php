
<div class="detail content">
    <h1>
        Généralités
    </h1>
    <?php
    /**
     * @var \App\Sae\Modele\DataObject\Etudiant $etudiant
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

