<form method='post' action='controleurFrontal.php'>
    <fieldset>
        <p>
            <label for='nomA_id'>Nom de l'agrégation</label> :
            <input type='text' placeholder='Nom Agregation' name='nomAgregation' id='nomA_id' required>
        </p>
        <br>
        <?php
        /**
         * @var \App\Sae\Modele\DataObject\Ressource[] $ressources
         * @var \App\Sae\Modele\DataObject\Agregation[] $agregations
         */
        $id = 0;
        if (!empty($ressources)) {
            echo '
            <p>Ressources :</p>';
            foreach ($ressources as $ressource) {
                echo "<p>Nom ".$ressource->getNomRessource() ."
                    <input type='hidden' name='idNom$id' value=".$ressource->getNomRessource().">  
                    <input type='number' name='coeff$id' value='0' id='coefRessource$id'>
                </p>";
                $id += 1;
            }
        }
        if (!empty($agregations)){
            foreach ($agregations as $agregation) {
                echo "<p> Nom ".$agregation->getNomAgregation() ."
                    <input type='hidden' name='idNom$id' value=".$agregation->getIdAgregation().">  
                    <input type='number' name='coeff$id' value='0' id='coefAgregation$id'>
                </p>";
                $id += 1;
            }
        }
        echo "<input type='hidden' name='count' value='$id'>";
        ?>
        <input type='hidden' name='action' value='construireDepuisFormulaire'>
        <input type="hidden" name="controleur" value="agregation">
        <input type="submit" name="envoyer">
    </fieldset>
</form>
