
<?php
/**
 * @var \App\Sae\Modele\DataObject\Agregation $agregation
 */
echo '<p> Nom agragation : '. htmlspecialchars($agregation->getNomAgregation()) .' </p>';

?>

<?php
/**
 * @var array $listeRessources
 */
if (!empty($listeRessources)) {
    echo "<h3>liste notes :</h3>";
    foreach ($listeRessources as $ressource) {
        echo "<p> Ressource : " . $ressource[0] . ' </p> <p> Coefficient : ' . $ressource[1] . "</p>";
    }
}

if(!empty($listeAgregations)){
    echo "<h3>liste agregations :</h3>";
    foreach ($listeAgregations as $agregation) {
        echo "<div class='cont' <p> id :" . $agregation[0] . ' </p> <p> Nom :' . htmlspecialchars($agregation[1]) . ' </p> <p> Coefficient : ' .$agregation[2] . "</p> </div>";
    }
}
?>