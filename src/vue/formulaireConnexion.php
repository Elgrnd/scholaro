<form method="get" action="controleurFrontal.php">
    <fieldset>
        <legend>Connexion :</legend>
        <input type='hidden' name='action' value='connecter'>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="login_id">Login</label>
            <input class="InputAddOn-field" type="text" placeholder="Ex : pallejax" name="login" id="login_id" required>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="mdp_id">Mot de passe</label>
            <input class="InputAddOn-field" type="password" value="" placeholder="" name="mdp" id="mdp_id" required>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="etudiantId">Étudiant</label>
            <input class="InputAddOn-field" type="radio" id="etudiantId" name="choix_controleur" value="utilisateur">
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="professeurId">Professeur</label>
            <input class="InputAddOn-field" type="radio" id="professeurId" name="choix_controleur" value="professeur">
        </p>
        <p>
            <input type="submit" value="Envoyer" />
        </p>
    </fieldset>
</form>