<?php
namespace App\Sae\Modele\Repository;

use App\Sae\Modele\DataObject\AbstractDataObject;
use App\Sae\Modele\DataObject\Agregation;

class AgregationRepository extends AbstractDataRepository
{
    protected function construireDepuisTableauSQL(array $objetFormatTableau): Agregation
    {
        return new Agregation($objetFormatTableau['idAgregation'], $objetFormatTableau['nomAgregation'], $objetFormatTableau['noteAgregation'], (new EtudiantRepository())->recupererParClePrimaire($objetFormatTableau['etudid']));
    }

    protected function getNomTable(): string
    {
       return "agregation";
    }

    protected function getNomClePrimaire(): string
    {
        return "idAgregation";
    }

    protected function getNomColonnes(): array
    {
        return ['idAgregation', 'nomAgregation', 'noteAgregation', 'etudid'];
    }

    protected function formatTableauSQL(AbstractDataObject $objet): array
    {
        return array(
            "idAgregationTag" => $objet->getIdAgregation(),
            "nomAgregationTag" => $objet->getNomAgregation(),
            "noteAgregationTag" => $objet->getNoteAgregation(),
            "etudidTag" => $objet->getEtudiant()->getEtudid()
        );
    }
}

?>