<div class="marge">
<div class="titre">
    <div class="table-title">
        <h1 >Liste Etudiant</h1>
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
    <tr>
        <th>Id Etudiant</th>
        <th>Nom</th>
        <th>Prenom</th>
        <?php /** @var \App\Sae\Modele\DataObject\Agregation $agregation*/ echo '<th>'.$agregation->getNomAgregation().'<a href="?controleur=etudiant&action=triCroissant&idAgregation='.rawurlencode($agregation->getIdAgregation()).'"> ⬆️ </a></th>'; ?>
        <th>Avis</th>
    </tr>
    </thead>


<tbody>
<?php
/**
 * @var \App\Sae\Modele\DataObject\Etudiant[] $etudiants
 */


foreach ($etudiants as $etudiant) {
    $etudiantAvis = $etudiant->getAvis();
    if ($etudiantAvis == "") {
        $etudiantAvis = "Pas d'avis";
    }
    echo '
   <tr>
   
    <td> <a href="?controleur=etudiant&action=afficherEtudiantPage&id='.rawurlencode($etudiant->getEtudid()).'">'. $etudiant->getEtudid() . '</a></td>
    <td> <a href="?controleur=etudiant&action=afficherEtudiantPage&id='.rawurlencode($etudiant->getEtudid()).'">' . htmlspecialchars($etudiant->getNomEtu()) . '</a> </td> 
    <td> <a href="?controleur=etudiant&action=afficherEtudiantPage&id='.rawurlencode($etudiant->getEtudid()).'">' . htmlspecialchars($etudiant->getPrenomEtu()) . '</a></td>
    <td> <a href="?controleur=etudiant&action=afficherEtudiantPage&id='.rawurlencode($etudiant->getEtudid()) .'">'. (new \App\Sae\Modele\Repository\EtudiantRepository())->getNoteEtudiantAgregation($etudiant->getEtudid(), $agregation->getIdAgregation()) .'</a></td>
    <td> <a href="?controleur=etudiant&action=afficherEtudiantPage&id='.rawurlencode($etudiant->getEtudid()).'">' . htmlspecialchars($etudiantAvis) . '</a></td>
    </tr>
     
    ';
}


?>
</tbody>
</table>
    <?php
    if (empty($etudiants)){
        echo '<h3 class="pas-etudiant">Il n\'y a aucun étudiant, veuillez en importer</h3>';
    } ?>
</div>

