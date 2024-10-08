<?php

namespace App\Sae\Modele\Repository;

use App\Sae\Modele\DataObject\AbstractDataObject;
use App\Sae\Modele\DataObject\Etudiant;

class EtudiantRepository extends AbstractDataRepository
{
    /**
     * @param array $objetFormatTableau
     * @return Etudiant permet de construire un étudiant depuis un tableau
     */

    protected function construireDepuisTableauSQL(array $objetFormatTableau): Etudiant
    {
        return new Etudiant($objetFormatTableau['etudid'], $objetFormatTableau['codenip'], $objetFormatTableau['civ'], $objetFormatTableau['nomEtu'], $objetFormatTableau['prenomEtu'], $objetFormatTableau['bac'], $objetFormatTableau['specialite'], $objetFormatTableau['rg_admis'], $objetFormatTableau['avis']);
    }

    /**
     * @return string nom de la table qui correspond à la classe Etudiant
     */
    protected function getNomTable(): string
    {
        return 'etudiant_temp';
    }

    protected function getNomClePrimaire(): string
    {
        return 'etudid';
    }

    protected function getNomColonnes(): array
    {
        return ["etudid", "codenip", "civ", "nom", "prenom", "bac", "specialite", "rg_admis", "avis"];
    }

    protected function formatTableauSQL(AbstractDataObject $objet): array
    {
        return array(
            "etudidTag" => $objet->getEtudid(),
            "codenipTag" => $objet->getCodenip(),
            "civTag" => $objet->getCiv(),
            "nomTag" => $objet->getNom(),
            "prenomTag" => $objet->getPrenom(),
            "bacTag" => $objet->getBac(),
            "specialiteTag" => $objet->getSpecialite(),
            "rg_admisTag" => $objet->getRg_admis(),
            "avisTag" => $objet->getAvis()
        );
    }

}