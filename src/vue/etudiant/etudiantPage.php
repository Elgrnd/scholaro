
<div class="detail content">
    <h1>
        Généralité
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
        Notes et Agrégation
    </h1>
    <?php

    /**
     *@var $notesAgregees \App\Sae\Modele\DataObject\Agregation[]
     */

    $idEtu = $etudiant->getEtudid();
    if (!empty($notes)) {
    echo "
    <form method='get' action='controleurFrontal.php'>
    <fieldset>
    <h3>Notes :</h3>";
    $id = 0;
        foreach ($notes as $note) {
            echo "Nom $note[2] : Note $note[3] <p>
                    <label for='noteId$id'> Agréger la note ?</label> :
                    <input type='checkbox' name='noteCheck$id' id='noteId$id'/>
                    <input type='hidden' value='$note[3]' name='noteagreger$id' id='noteaAgreger$id'/>
                    <input type='number' name='coeff$id' value='1' id='coefNote$id'/>
                    <input type='hidden' name='idNom$id' value='$note[2]'/>
                </p>";
            $id+= 1;
        }
        if(!empty($notesAgregees)){
            echo "<h3> Notes agrégées : </h3>";
            foreach ($notesAgregees as $noteAgregee) {
                echo '
                <p> Nom : '.$noteAgregee->getNomAgregation() .'  Note : '.$noteAgregee->getNoteAgregation() .'<a href="?controleur=etudiant&action=supprimerAgregation&idNoteAgregee=' . rawurldecode($noteAgregee->getIdAgregation()) . '&etudid='.$etudiant->getEtudid().'"> Supprimer l\'agregation  </a></p>
                    <p>
                    <label for="noteAgregationId'.$id.'"> Agréger l\'agregation ?</label> :
                    <input type="checkbox" name="noteCheck'.$id.'" id="noteAgregationId'.$id.'"/>
                    <input type="hidden" value='.$noteAgregee->getNoteAgregation().' name="noteagreger'.$id.'" id="AgregationaAgreger'.$id.'"/>
                    <input type="number" name="coeff'.$id.'" value="1" id="coefAgregation'.$id.'"/>
                    <input type="hidden" name="idNom'.$id.'" value='.$noteAgregee->getIdAgregation().'>  
                </p>';
                $id+= 1;
            }
        }
        foreach ($notes as $note) {}
        echo "
                <p>
                    <label for='nomA_id'>Nom de l'agrégation</label> :
                    <input type='text' placeholder='Nom Agregation' name='nomAgregation' id='nomA_id' required/>
                    <input type='hidden' name='action' value='creerAgregation'>
                    <input type='hidden' name='controleur' value='etudiant'>
                    <input type='hidden' name='etuid' value='$idEtu'>
                    <input type='hidden' name='id' value='$id'>
                    <input type='submit' value='Envoyer' />
                </p>
    </fieldset>
        </form>";
    } else {
        echo "<p> L'étudiant n'a pas de notes</p>";
    }

    if($etudiant->getAvis() != null) {
        echo '<p> Avis </p>';
        echo '<p>' . htmlspecialchars($etudiant->getAvis()) . ' </p>';
    }
    ?>
</div>

