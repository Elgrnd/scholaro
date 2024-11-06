<?php

namespace App\Sae\Modele\Repository;

use App\Sae\Modele\DataObject\AbstractDataObject;
use App\Sae\Modele\Repository\AbstractDataRepository;
use App\Sae\Modele\DataObject\Professeur;

class ProfesseurRepository extends AbstractDataRepository
{
    /**
     * @param array $objetFormatTableau
     * @return Professeur permet de construire un professeur depuis un tableau
     */

    protected function construireDepuisTableauSQL(array $objetFormatTableau): Professeur
    {
        return new Professeur(
            $objetFormatTableau["nomProf"],
            $objetFormatTableau["prenomProf"],
            $objetFormatTableau["loginProf"],
            $objetFormatTableau["mdpHache"],
            $objetFormatTableau["estAdmin"],
        );
    }

    /**
     * @return string nom de la table qui correspond à la classe Professeur
     */
    protected function getNomTable(): string
    {
        return 'professeur';
    }

    protected function getNomClePrimaire(): string
    {
        return "loginProf";
    }

    protected function getNomColonnes(): array
    {
        return ["nomProf", "prenomProf", "loginProf", "mdpHache", "estAdmin"];
    }

    protected function formatTableauSQL(AbstractDataObject $objet): array
    {
        $val = $objet->isEstAdmin() ? 1 : 0;
        return array(
            "nomProf" => $objet->getNomProf(),
            "prenomProf" => $objet->getPrenomProf(),
            "loginProf" => $objet->getLoginProf(),
            "mdpHache" => $objet->getMdpHache(),
            "estAdmin" => $val
        );
    }
}