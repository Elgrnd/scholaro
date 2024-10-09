<form action="controleurFrontal.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="controleur" value="etudiant">
    <input type="hidden" name="action" value="ajouterDepuisCSV">
    <div>
        <label for="file">Choisissez votre fichier (.csv) : </label>
        <input type="file" id="file" name="file" accept=".csv">
        <button type="submit" name="import">Valider</button>
    </div>
</form>
