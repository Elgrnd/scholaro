<?php
namespace App\Sae\Modele\Repository;
use App\Sae\Modele\DataObject\AbstractDataObject as AbstractDataObject;
use App\Sae\Modele\Repository\ConnexionBaseDeDonnees as ConnexionBaseDeDonnees;
abstract class AbstractDataRepository
{
    protected abstract function construireDepuisTableauSQL(array $objetFormatTableau) : AbstractDataObject;
    protected abstract function getNomTable(): string;

    /**
     * @return array|null
     * retourne une liste des objets d'une même classe
     * renvoie null si aucun objet n'est créer
     */

    public function recuperer() : ?array
    {
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->query('SELECT * FROM '. $this->getNomTable());
        foreach ($pdoStatement as $objetFormatTableau) {
            $tableauObjets[] = $this->construireDepuisTableauSQL($objetFormatTableau);
        }
        return $tableauObjets;
    }
}