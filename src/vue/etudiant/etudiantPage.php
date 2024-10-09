<?php
/**
 * @var \App\Sae\Modele\DataObject\Etudiant $etudiant
 */
echo "<p>echo </p>";
echo $etudiant->getEtudid();

if (!empty($notes)) {
echo "<p>Note élève</p>";

    foreach ($notes as $note) {
        echo "<br>";
        echo "$note[2] :  $note[3]";
    }
} else {
    echo "<p> l'étudiant n'a pas de notes</p>";
}

echo '<p> Avis </p>';
echo '<p>' . $etudiant->getAvis() . ' </p>'
?>

