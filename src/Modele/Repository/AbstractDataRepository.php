<?php
namespace App\Sae\Modele\Repository;
use App\Sae\Modele\DataObject\AbstractDataObject as AbstractDataObject;
use App\Sae\Modele\Repository\ConnexionBaseDeDonnees as ConnexionBaseDeDonnees;
abstract class AbstractDataRepository
{
    protected abstract function construireDepuisTableauSQL(array $objetFormatTableau) : AbstractDataObject;
    protected abstract function getNomTable(): string;

    protected abstract function getNomClePrimaire(): string;
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

    public function recupererParClePrimaire(string $clefPrimTag): ?AbstractDataObject
    {
        $sql = 'SELECT * from ' . $this->getNomTable() . ' WHERE ' . $this->getNomClePrimaire() . ' = :clefPrimTag';
        // Préparation de la requête
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $values = array(
            "clefPrimTag" => $clefPrimTag,
            //nomdutag => valeur, ...
        );
        // On donne les valeurs et on exécute la requête
        $pdoStatement->execute($values);

        // On récupère les résultats comme précédemment
        // Note: fetch() renvoie false si pas d'utilisateur correspondant

        $objetFormatTableau = $pdoStatement->fetch();
        if ($objetFormatTableau == null) {
            //echo "ERREUR MADE IN MOI";
            return null;
        }
        return $this->construireDepuisTableauSQL($objetFormatTableau);
    }
}