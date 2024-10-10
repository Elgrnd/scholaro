<?php
namespace App\Sae\Modele\Repository;

use App\Sae\Modele\DataObject\AbstractDataObject;
use App\Sae\Modele\DataObject\Etudiant;
use MongoDB\Driver\Exception\Exception;

class EtudiantRepository extends AbstractDataRepository
{
    /**
     * @param array $objetFormatTableau
     * @return Etudiant permet de construire un étudiant depuis un tableau
     */

    protected function construireDepuisTableauSQL(array $objetFormatTableau): Etudiant
    {
        return new Etudiant($objetFormatTableau['etudid'], $objetFormatTableau['codenip'], $objetFormatTableau['civ'] ,$objetFormatTableau['nomEtu'], $objetFormatTableau['prenomEtu'], $objetFormatTableau['bac'], $objetFormatTableau['specialite'], $objetFormatTableau['rg_admis'], $objetFormatTableau['avis']);
    }

    /**
     * @return string nom de la table qui correspond à la classe Etudiant
     */
    protected function getNomTable(): string
    {
        return 'etudiant';
    }

    protected function getNomClePrimaire(): string
    {
        return "etudid";
    }

    /**
     * @param int $id
     * @return array|null retourne toutes les notes d'un étudiant s'il en a sinon renvoie null
     */
    public function getNotesEtudiant(int $id) : ?array {
        $sql = "SELECT * FROM etu_Note_Semestre WHERE etudid = :idTag";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values = array(
            "idTag" => $id,
        );
        $tab = array();
        try {
            $pdoStatement->execute($values);
        }
        catch (Exception $e){
            return null;
        }
        foreach ($pdoStatement as $row) {
            $tab[] = $row;
        }
        return $tab;
    }

    protected function getNomColonnes(): array
    {
        return ["etudid", "codenip", "civ", "nomEtu", "prenomEtu", "bac", "specialite", "rg_admis", "avis"];
    }

    protected function formatTableauSQL(AbstractDataObject $objet): array
    {
        return array(
            "etudidTag"=> $objet->getEtudid(),
            "codenipTag" => $objet->getCodenip(),
            "civTag" => $objet->getCiv(),
            "nomEtuTag" => $objet->getNomEtu(),
            "prenomEtuTag" => $objet->getPrenomEtu(),
            "bacTag"=> $objet->getBac(),
            "specialiteTag" => $objet->getSpecialite(),
            "rg_admisTag" => $objet->getRgadmis(),
            "avisTag"=> $objet->getAvis()
        );
    }
}