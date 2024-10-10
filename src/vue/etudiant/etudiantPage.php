<?php
/**
 * @var \App\Sae\Modele\DataObject\Etudiant $etudiant
 */
$nomEtudiant = htmlspecialchars($etudiant->getNomEtu());
$prenomEtudiant = htmlspecialchars($etudiant->getPrenomEtu());
$codenip = htmlspecialchars($etudiant->getCodenip());
$civ = htmlspecialchars($etudiant->getCiv());
$bac = htmlspecialchars($etudiant->getBac());
$specialite = htmlspecialchars($etudiant->getSpecialite());
$rang_admis = htmlspecialchars($etudiant->getRgadmis());
$avis = htmlspecialchars($etudiant->getAvis());
$idEtu = $etudiant->getEtudid();


if (!empty($notes)) {
echo "<p>Note élève</p>
<form method='get' action='controleurFrontal.php'>
<fieldset>";
$id = 0;
    foreach ($notes as $note) {
        echo "<br>";
        echo "$note[2] :  $note[3] <p>
                <label for='noteId$id'> agregation</label> :
                <input type='checkbox' name='noteCheck$id' id='noteId$id'/>
                <input type='hidden' value='$note[3]' name='noteagreger$id' id='noteaAgreger$id'/>
            </p>";
        $id+= 1;
    }
    echo " <p>
                <label for='nomA_id'>Nom de l'agragation</label> :
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
    echo "<p> l'étudiant n'a pas de notes</p>";
}
if($etudiant->getAvis() != null) {
    echo '<p> Avis </p>';
    echo '<p>' . $etudiant->getAvis() . ' </p>';
}
/**
 *@var $notesAgregees \App\Sae\Modele\DataObject\Agregation[]
 */
if(!empty($notesAgregees)){
    echo "<p>notes Agregater de l'élève </p>";
    foreach ($notesAgregees as $noteAgregee) {
        echo '<p> Nom : '.$noteAgregee->getNomAgregation() .'  Note : '.$noteAgregee->getNoteAgregation() .' Supprimer l\'agregation <a href="?controleur=etudiant&action=supprimerAgregation&idNoteAgregee=' . rawurldecode($noteAgregee->getIdAgregation()) . '&etudid='.$etudiant->getEtudid().'"> supprimer </a></p>';
    }
}
?>

