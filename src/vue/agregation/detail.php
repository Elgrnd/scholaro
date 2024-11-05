
<?php
/**
 * @var \App\Sae\Modele\DataObject\Agregation $agregation
 */
echo $agregation->getIdAgregation() .' '. $agregation->getNomAgregation() .' '. $agregation->getNoteAgregation();

?>
<br>
<?php
/**
 * @var array $listeRessources
 */
if (!empty($listeRessources)) {
    echo "liste notes : <br>";
    foreach ($listeRessources as $ressource) {
        echo $ressource[0] . ' ' . $ressource[1] . ' ' . $ressource[2] . '<br>';
    }
}

if(!empty($listeAgregations)){
    echo "liste agregations : <br>";
    foreach ($listeAgregations as $agregation) {
        echo $agregation[0] . ' ' . $agregation[1] . ' ' . $agregation[2] .' ' .$agregation[3]. '<br>';
    }
}
?>