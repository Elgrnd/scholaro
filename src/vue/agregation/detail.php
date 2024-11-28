<?php
/**
 * @var \App\Sae\Modele\DataObject\Agregation $agregation
 * @var array $listeRessources
 */

echo '<div id="agregation-details">';
echo '<h2 class="agregation-title">' . htmlspecialchars($agregation->getNomAgregation()) . '</h2>';

// Section des ressources
if (!empty($listeRessources)) {
    echo '<div class="ressources-section">';
    echo '<h3 class="ressources-title">Liste des notes :</h3>';
    foreach ($listeRessources as $ressource) {
        echo '<div class="ressource-item">';
        echo '<p class="ressource-name">Ressource : ' . htmlspecialchars($ressource[0]) . '</p>';
        echo '<p class="ressource-coef">Coefficient : ' . htmlspecialchars($ressource[1]) . '</p>';
        echo '</div>';
    }
    echo '</div>';
}

// Section des agrégations
if (!empty($listeAgregations)) {
    echo '<div class="agregations-section">';
    echo '<h3 class="agregations-title">Liste des agrégations :</h3>';
    foreach ($listeAgregations as $agregations) {
        $id = htmlspecialchars($agregations[0]);
        echo '<div class="agregation-item">';
        echo '<p class="agregation-id">ID : <a href="controleurFrontal.php?action=afficherDetail&controleur=agregation&id=' . $id . '" class="agregation-link">' . $id . '</a></p>';
        echo '<p class="agregation-coef">Coefficient : ' . htmlspecialchars($agregations[1]) . '</p>';
        echo '</div>';
    }
    echo '</div>';
}

// Bouton de suppression
echo '<a href="controleurFrontal.php?action=supprimer&controleur=agregation&id=' . htmlspecialchars($agregation->getIdAgregation()) . '" 
       class="delete-agregation-link" 
       onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cette agrégation ? \nCela peut modifier d\\\'autres agrégations.\');">';
echo '<div class="delete-agregation-button">Supprimer l\'agrégation</div>';
echo '</a>';

echo '</div>';
