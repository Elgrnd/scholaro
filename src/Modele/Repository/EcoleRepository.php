<?php

namespace App\Sae\Modele\Repository;

use App\Sae\Modele\DataObject\AbstractDataObject;
use App\Sae\Modele\Repository\AbstractDataRepository;
use App\Sae\Modele\DataObject\Ecole;

class EcoleRepository extends AbstractDataRepository
{

    protected function getNomTable(): string
    {
        return "ecolePartenaire";
    }

    protected function getNomClePrimaire(): string
    {
        return "idEcole";
    }

    protected function getNomColonnes(): array
    {
        return ['idEcole', 'nomEcole', 'villeEcole'];
    }

    protected function construireDepuisTableauSQL(array $objetFormatTableau) : Ecole {
        return new Ecole($objetFormatTableau["idEcole"], $objetFormatTableau["nomEcole"], $objetFormatTableau["villeEcole"]);
    }
    protected function formatTableauSQL(AbstractDataObject $objet): array
    {
        return array(
            "idEcoleTag" => $objet->getIdEcole(),
            "nomEcoleTag" => $objet->getNomEcole(),
            "villeEcoleTag" => $objet->getVilleEcole(),
        );
    }

    public function recupererEcoleFavoris($idEtudiant)
    {
        $sql = "SELECT * FROM ecolePartenaire JOIN ecoleFavoris on ecoleFavoris.idEcole = ecolePartenaire.idEcole WHERE idEtudiant = :idEtudiantTag";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values = array("idEtudiantTag" => $idEtudiant);
        $pdoStatement->execute($values);
        $tableauObjets = [];
        foreach ($pdoStatement as $objetFormatTableau) {
            $tableauObjets[] = $this->construireDepuisTableauSQL($objetFormatTableau);
        }
        return $tableauObjets;
    }

    public function recupererAvis($idEtudiant)
    {
        $sql = "SELECT idEcole, avis, commentaire FROM ecoleFavoris WHERE idEtudiant = :idEtudiantTag";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values = array("idEtudiantTag" => $idEtudiant);
        $pdoStatement->execute($values);
        $tableauObjets = [];
        foreach ($pdoStatement as $objetFormatTableau) {
            $tableauObjets[$objetFormatTableau["idEcole"]] = [$objetFormatTableau["avis"], $objetFormatTableau["commentaire"]];
        }
        return $tableauObjets;
    }


}