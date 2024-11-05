
<?php
/**
 * @var \App\Sae\Modele\DataObject\Agregation $agregation
 */docs
echo '<p> Nom agragation : '. $agregation->getNomAgregation() .' </p> <p> Note : '. $agregation->getNoteAgregation() . "</p>";

?>

<?php
/**
 * @var array $listeRessources
 */
if (!empty($listeRessources)) {
    echo "<h3>liste notes :</h3>";
    foreach ($listeRessources as $ressource) {
        echo "<p> Ressource : " . $ressource[0] . ' </p> <p> Note : ' . $ressource[1] . ' </p> <p> Coefficient : ' . $ressource[2] . "</p>";
    }
}

if(!empty($listeAgregations)){
    echo "<h3>liste agregations :</h3>";
    foreach ($listeAgregations as $agregation) {
        echo "<div class='cont' <p> id :" . $agregation[0] . ' </p> <p> Nom :' . $agregation[1] . ' </p> <p> Note : ' . $agregation[2] .'</p> <p> Coefficient : ' .$agregation[3] . "</p> </div>";
    }
}
?>