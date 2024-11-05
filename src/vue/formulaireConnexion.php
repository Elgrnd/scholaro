<form method="get" action="controleurFrontal.php">
    <fieldset>
        <legend>Connexion :</legend>
        <input type='hidden' name='action' value='connecter'>
        <input type="hidden" name="controleur" value="utilisateur">
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="login_id">Login&#42;</label>
            <input class="InputAddOn-field" type="text" placeholder="Ex : leblancj" name="login" id="login_id" required>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="mdp_id">Mot de passe&#42;</label>
            <input class="InputAddOn-field" type="password" value="" placeholder="" name="mdp" id="mdp_id" required>
        </p>
        <p>
            <input type="submit" value="Envoyer" />
        </p>
        <input type='hidden' name='action' value='enregistrerPreference'>
        <input type="radio" id="utilisateurId" name="controleur_defaut" value="utilisateur">
        <label for="utilisateurId">Utilisateur</label>
        <input type="radio" id="trajetId" name="controleur_defaut" value="trajet">
        <label for="trajetId">Trajet</label>
        <p class="InputAddOn">
            <input class="InputAddOn-field" type="submit" value="Envoyer" />
        </p>
    </fieldset>
</form>