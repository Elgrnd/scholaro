<?php
/**
 * @var \App\Sae\Modele\DataObject\Etudiant[] $etudiants
 */
foreach ($etudiants as $etudiant) {
    echo '<div class="etudiant-info">';
    echo '<div class="etudiant-id">';
    echo '<p>Id Etudiant : ' . $etudiant->getEtudid() . '</p>';
    echo '</div>';
    echo '<div class="etudiant-details">';
    echo '<p>Nom : ' . $etudiant->getNom() . ' Prénom : ' . $etudiant->getPrenom() . '</p>';
    echo '</div>';
    echo '</div>';
}
?>