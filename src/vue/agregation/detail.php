
<?php
/**
 * @var \App\Sae\Modele\DataObject\Agregation $agregation
 * @var array $listeRessources
 * @var float $moyenne
 */
echo '<h2>' . htmlspecialchars($agregation->getNomAgregation()) .'</h2>';

if (!empty($listeRessources)) {
    echo "<h3>liste notes :</h3>";
    foreach ($listeRessources as $ressource) {
        echo "<p> Ressource : " . $ressource[0] . ' </p> <p> Coefficient : ' . $ressource[1] . "</p>";
    }
}

if(!empty($listeAgregations)){
    echo "<h3>liste agregations :</h3>";
    foreach ($listeAgregations as $agregations) {
        $id = $agregations[0];
        echo "<div> <p> id : <a href='controleurFrontal.php?action=afficherDetail&controleur=agregation&id=$id'>" . $id . ' </p></a> <p> Coefficient : ' .$agregations[1] . "</p> </div>";
    }
}

echo "<h3> moyenne : " . $moyenne . " </h3>";

?>

<a href="controleurFrontal.php?action=supprimer&controleur=agregation&id=<?= $agregation->getIdAgregation()?>"
   onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette agrégation ? \nCela peut modifier d\'autres agrégations.');">
    <div>
        Supprimer l'agrégation
    </div>
</a>
