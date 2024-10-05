<?php
namespace App\Sae\Modele\Repository;

use App\Sae\Modele\Repository\ConnexionBaseDeDonnees;
use App\Sae\Modele\DataObject\Etudiant;
use PDOException;
class EtudiantRepository extends AbstractDataRepository
{
    /**
     * @param array $objetFormatTableau
     * @return Etudiant permet de construire un étudiant depuis un tableau
     */

    protected function construireDepuisTableauSQL(array $objetFormatTableau): Etudiant
    {
        return new Etudiant($objetFormatTableau['etudid'], $objetFormatTableau['codenip'], $objetFormatTableau['civ'] ,$objetFormatTableau['nom'], $objetFormatTableau['prenom'], $objetFormatTableau['bac'], $objetFormatTableau['specialite'], $objetFormatTableau['rgadmis'], $objetFormatTableau['avis']);
    }

    /**
     * @return string nom de la table qui correspond à la classe Etudiant
     */
    protected function getNomTable(): string
    {
        return 'etudiant';
    }

}