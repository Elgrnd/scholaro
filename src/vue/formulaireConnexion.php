<form method=<?php if (\App\Sae\Configuration\ConfigurationSite::getDebug()) echo "get"; else echo "post" ?> action="controleurFrontal.php">
    <fieldset>
        <legend>Connexion :</legend>
        <input type='hidden' name='action' value='connecter'>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="login_id">Login&#42;</label>
            <input class="InputAddOn-field" type="text" placeholder="Ex : 000 | leblancj" name="login" id="login_id" required>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="mdp_id">Mot de passe&#42;</label>
            <input class="InputAddOn-field" type="password" value="" placeholder="" name="mdp" id="mdp_id" required>
        </p>
        <p class="InputAddOn">
            <input class="InputAddOn-field" type="radio" id="etudiantId" name="controleur" value="etudiant" checked>
            <label class="InputAddOn-item" for="etudiantId">Étudiant</label>
        </p>
        <p class="InputAddOn">
            <input class="InputAddOn-field" type="radio" id="professeurId" name="controleur" value="professeur">
            <label class="InputAddOn-item" for="professeurId">Professeur</label>
        </p>
        <p>
            <input type="submit" value="Envoyer">
        </p>
        <h5 class="champs">
            * champs requis
        </h5>
    </fieldset>
</form>