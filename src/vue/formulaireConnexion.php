<form method="get" action="controleurFrontal.php">
    <fieldset>
        <legend>Connexion :</legend>
        <input type='hidden' name='action' value='connecter'>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="login_id">Login&#42;</label>
            <input class="InputAddOn-field" type="text" placeholder="Ex : leblancj" name="login" id="login_id" required>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="mdp_id">Mot de passe&#42;</label>
            <input class="InputAddOn-field" type="password" value="" placeholder="" name="mdp" id="mdp_id" required>
        </p>
        <form action="controleurFrontal.php" method="get">
            <input type='hidden' name='action' value='enregistrerControleur'>
            <p class="InputAddOn">
                <input class="InputAddOn-field" type="radio" id="etudiantId" name="choix_controleur" value="etudiant" onchange="this.form.submit()">
                <label class="InputAddOn-item" for="etudiantId">Étudiant</label>
            </p>
            <p class="InputAddOn">
                <input class="InputAddOn-field" type="radio" id="professeurId" name="choix_controleur"
                       value="professeur" onchange="this.form.submit()">
                <label class="InputAddOn-item" for="professeurId">Professeur</label>
            </p>
        </form>
        <p>
            <input type="submit" value="Envoyer"/>
        </p>
    </fieldset>
</form>