<?php

namespace App\Sae\Modele\Repository;

use App\Sae\Modele\DataObject\AbstractDataObject;
use App\Sae\Modele\DataObject\Ressource;

class RessourceRepository extends AbstractDataRepository
{

    protected function construireDepuisTableauSQL(array $objetFormatTableau): AbstractDataObject
    {
        return new Ressource($objetFormatTableau['nomRessource']);
    }

    protected function getNomTable(): string
    {
        return 'ressource';
    }

    protected function getNomClePrimaire(): string
    {
        return 'nomRessource';
    }

    protected function getNomColonnes(): array
    {
        return ['nomRessource'];
    }

    protected function formatTableauSQL(AbstractDataObject $objet): array
    {

        return array(
            "nomRessourceTag"=> $objet->getNomRessource()
        );
    }

}
