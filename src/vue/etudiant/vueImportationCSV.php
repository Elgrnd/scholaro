<form action="controleurFrontal.php" method="get">
    <input type="hidden" name="controleur" value="etudiant">
    <input type="hidden" name="action" value="ajouterDepuisCSV">
    <div>
        <label for="choixFichier">Choisissez votre fichier (.csv) : </label>
        <input type="file" id="file" name="file" accept=".csv">
        <button type="submit">Valider</button>
    </div>
</form>
