<?php
/**
 * @var \App\Sae\Modele\DataObject\Etudiant $etudiant
 */
echo "<p>echo </p>";
$idEtu = $etudiant->getEtudid();
echo $idEtu;

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

echo '<p> Avis </p>';
echo '<p>' . $etudiant->getAvis() . ' </p>'
?>

