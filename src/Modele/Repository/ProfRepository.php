<?php
namespace App\Sae\Modele\Repository;

use App\Sae\Modele\DataObject\AbstractDataObject;
use App\Sae\Modele\DataObject\Prof;

class ProfRepository extends AbstractDataRepository {

    protected function construireDepuisTableauSQL(array $objetFormatTableau): AbstractDataObject
    {
       return new Prof($objetFormatTableau["loginProf"], $objetFormatTableau["nomProf"], $objetFormatTableau["prenomProf"], $objetFormatTableau["mailUniversitaire"], $objetFormatTableau["estAdmin"]);
    }

    protected function getNomTable(): string
    {
        return "prof";
    }

    protected function getNomClePrimaire(): string
    {
        return "loginProf";
    }

    protected function getNomColonnes(): array
    {
        return ["loginProf", "nomProf", "prenomProf", "mailUniversitaire", "estAdmin"];
    }

    protected function formatTableauSQL(AbstractDataObject $prof): array
    {
        return array(
            "loginProfTag" => $prof->getLoginProf(),
            "nomProfTag" => $prof->getNomProf(),
            "prenomProfTag" => $prof->getPrenomProf(),
            "mailUniversitaireTag" => $prof->getMailUniversitaire(),
            "estAdminTag" => intval($prof->isEstAdmin())
        );
    }

}