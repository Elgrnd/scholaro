
<div class="titre">
    <div>
        <h2 class="table-title">Liste Etudiant</h2>
    </div>
    <div>
        <p ><a href="" class="padd">Importer des étudiants</a></p>
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
    <td><a href="?controleur=etudiant&action=afficherEtudiantPage&id='.$etudiant->getEtudid().'">'. $etudiant->getCiv() . '</a></td>
    <td> <a href="?controleur=etudiant&action=afficherEtudiantPage&id='.$etudiant->getEtudid().'">' . $etudiant->getNomEtu() . '</a> </td> 
    <td> <a href="?controleur=etudiant&action=afficherEtudiantPage&id='.$etudiant->getEtudid().'">' . $etudiant->getPrenomEtu() . '</a></td>
    <td> <a href="?controleur=etudiant&action=afficherEtudiantPage&id='.$etudiant->getEtudid().'">' . $etudiant->getBac() . '</a></td>
    <td> <a href="?controleur=etudiant&action=afficherEtudiantPage&id='.$etudiant->getEtudid().'">' . $etudiant->getRgadmis() . '</a></td>
    <td> <a href="?controleur=etudiant&action=afficherEtudiantPage&id='.$etudiant->getEtudid().'">' . $etudiant->getAvis() . '</a></td>
    </tr>
    
    ';
}

?>
</tbody>
</table>

