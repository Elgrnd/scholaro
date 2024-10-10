<div class="marge">
<div class="titre">
    <div class="table-title">
        <h2 >Liste Etudiant</h2>
    </div>
    <div class="bouton-importation">
        <form action="controleurFrontal.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="controleur" value="etudiant">
            <input type="hidden" name="action" value="ajouterDepuisCSV">
            <div>
                <input type="file" id="file" name="file" accept=".csv" style="display: none;" onchange="this.form.submit()">
                <label for="file" >
                    Importer Etudiant (.csv)
                </label>
            </div>
        </form>

    </div>
</div>

<table>
    <thead>
        <th>Id Etudiant</th>
        <th>Civilité</th>
        <th>Nom</th>
        <th>Prenom</th>
        <th>Bac</th>
        <th>Rang admission</th>
        <th>Avis</th>
    </thead>


<tbody>
<?php
/**
 * @var \App\Sae\Modele\DataObject\Etudiant[] $etudiants
 */
foreach ($etudiants as $etudiant) {
    echo '
   <tr>
   
    <td> <a href="?controleur=etudiant&action=afficherEtudiantPage&id='.$etudiant->getEtudid().'">'. $etudiant->getEtudid() . '</a></td>
    <td><a href="?controleur=etudiant&action=afficherEtudiantPage&id='.$etudiant->getEtudid().'">'. htmlspecialchars($etudiant->getCiv()) . '</a></td>
    <td> <a href="?controleur=etudiant&action=afficherEtudiantPage&id='.$etudiant->getEtudid().'">' . htmlspecialchars($etudiant->getNomEtu()) . '</a> </td> 
    <td> <a href="?controleur=etudiant&action=afficherEtudiantPage&id='.$etudiant->getEtudid().'">' . htmlspecialchars($etudiant->getPrenomEtu()) . '</a></td>
    <td> <a href="?controleur=etudiant&action=afficherEtudiantPage&id='.$etudiant->getEtudid().'">' . htmlspecialchars($etudiant->getBac()) . '</a></td>
    <td> <a href="?controleur=etudiant&action=afficherEtudiantPage&id='.$etudiant->getEtudid().'">' . htmlspecialchars($etudiant->getRgadmis()) . '</a></td>
    <td> <a href="?controleur=etudiant&action=afficherEtudiantPage&id='.$etudiant->getEtudid().'">' . htmlspecialchars($etudiant->getAvis()) . '</a></td>
    </tr>
     
    ';
}

?>
</tbody>
</table>

</div>

