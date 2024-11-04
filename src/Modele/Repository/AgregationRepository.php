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

    /**
     * @param int $idAgregation
     * @return array retourne la liste des ressources qui ont été agregées
     */
    public function listeRessourcesAgregees(int $idAgregation, int $etudid): array
    {
        $sql = "SELECT r.nomRessource, note, coefficient 
        FROM agregerRessource a 
        JOIN ressource r ON a.nomRessource = r.nomRessource 
        JOIN noter e ON e.nomRessource = r.nomRessource WHERE idAgregation = :idAgregationTag AND etudid = :etudidTag";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values = array("idAgregationTag" => $idAgregation,
            "etudidTag" => $etudid);
        $tab = [];
        $pdoStatement->execute($values);
        foreach($pdoStatement as $row){
            $tab[] = $row;
        }
        return $tab;
    }

    /**
     * @param int $idAgregation
     * @return array retourne la liste des agregations qui ont été agrégées
     */
    public function listeAgregationsAgregees(int $idAgregation): array
    {
        $sql = "SELECT aa.idAgregationAgregee, nomAgregation, noteAgregation, coefficient 
        FROM agregerAgregation aa
        JOIN agregation a ON a.idAgregation = aa.idAgregationAgregee
        WHERE aa.idAgregation = :idAgregationTag";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values = array(
            "idAgregationTag" => $idAgregation
        );
        $pdoStatement->execute($values);
        $tab = [];
        foreach ($pdoStatement as $row){
            $tab[] = $row;
        }
        return $tab;
    }
}

?>