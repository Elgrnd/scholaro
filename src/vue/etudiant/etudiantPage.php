<?php
/**
 * @var \App\Sae\Modele\DataObject\Etudiant $etudiant
 */
/**
 *@var $notesAgregees \App\Sae\Modele\DataObject\Agregation[]
 */

$idEtu = $etudiant->getEtudid();
if (!empty($notes)) {
echo "
<form method='get' action='controleurFrontal.php'>
<fieldset>
<p>Notes de l'élève :</p>";
$id = 0;
    foreach ($notes as $note) {
        echo "<br>";
        echo "Nom $note[2] : Note $note[3] <p>
                <label for='noteId$id'> Agrégée la note</label> :
                <input type='checkbox' name='noteCheck$id' id='noteId$id'/>
                <input type='hidden' value='$note[3]' name='noteagreger$id' id='noteaAgreger$id'/>
                <input type='number' name='coeff$id' value='1' id='coefNote$id'/>
                <input type='hidden' name='idNom$id' value='$note[2]'/>
            </p>";
        $id+= 1;
    }
    echo "<br>";
    if(!empty($notesAgregees)){
        echo "<p> Notes agrégées de l'élève : </p>";
        foreach ($notesAgregees as $noteAgregee) {
            echo '<br> 
            <p> Nom : '.$noteAgregee->getNomAgregation() .'  Note : '.$noteAgregee->getNoteAgregation() .'<a href="?controleur=etudiant&action=supprimerAgregation&idNoteAgregee=' . rawurldecode($noteAgregee->getIdAgregation()) . '&etudid='.$etudiant->getEtudid().'"> Supprimer l\'agregation  </a></p>
                <p>
                <label for="noteAgregationId'.$id.'"> Agrégée l\'agregation</label> :
                <input type="checkbox" name="noteCheck'.$id.'" id="noteAgregationId'.$id.'"/>
                <input type="hidden" value='.$noteAgregee->getNoteAgregation().' name="noteagreger'.$id.'" id="AgregationaAgreger'.$id.'"/>
                <input type="number" name="coeff'.$id.'" value="1" id="coefAgregation'.$id.'"/>
                <input type="hidden" name="idNom$'.$id.'" value='.$noteAgregee->getIdAgregation().'>  
            </p>';
            $id+= 1;
        }
    }
    foreach ($notes as $note) {}
    echo "<br> 
            <p>
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


?>

