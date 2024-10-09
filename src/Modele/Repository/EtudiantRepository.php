<?php
namespace App\Sae\Modele\Repository;

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

}