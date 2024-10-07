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
    echo '<p>Nom : ' . $etudiant->getNomEtu() . ' Prénom : ' . $etudiant->getPrenomEtu() . '</p>';
    echo '</div>';
    echo '</div>';
}
?>