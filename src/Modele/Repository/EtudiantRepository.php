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
        return new Etudiant($objetFormatTableau['etudid'],
            $objetFormatTableau['codenip'],
            $objetFormatTableau['civ'],
            $objetFormatTableau['nomEtu'],
            $objetFormatTableau['prenomEtu'],
            $objetFormatTableau['bac'],
            $objetFormatTableau['specialite'],
            $objetFormatTableau['rg_admis'],
            $objetFormatTableau['avis'],
            $objetFormatTableau['login']);
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

    public function enregistrerRessource($nomRessource): ?bool
    {
        $sql = "INSERT IGNORE INTO ressource (nomRessource) 
            VALUES (:nomRessourceTag)";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values = array(
            "nomRessourceTag" => $nomRessource,
        );
        $pdoStatement->execute($values);
        $objetFormatTableau = $pdoStatement->fetch();
        if ($objetFormatTableau == null) {
            return null;
        }
        return true;
    }

    public function enregistrerNotesEtudiant(string $etudid, int $semestre_id, string $nomRessource, float $note) : ?bool{
        $sql = "INSERT IGNORE INTO noter (etudid, semestre_id, nomRessource, note) 
            VALUES (:etudidTag, :semestre_idTag, :nomRessourceTag, :noteTag)";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values = array(
            "etudidTag" => $etudid,
            "semestre_idTag" => $semestre_id,
            "nomRessourceTag" => $nomRessource,
            "noteTag" => $note
        );
        $pdoStatement->execute($values);
        $objetFormatTableau = $pdoStatement->fetch();
        if ($objetFormatTableau == null) {
            return null;
        }
        return true;
    }

    /**
     * @param int $id
     * @return array|null retourne toutes les notes d'un étudiant s'il en a sinon renvoie null
     */
    public function getNotesEtudiant(int $id): ?array
    {
        $sql = "SELECT * FROM noter WHERE etudid = :idTag";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values = array(
            "idTag" => $id,
        );
        $tab = array();
        try {
            $pdoStatement->execute($values);
        } catch (Exception $e) {
            return null;
        }
        foreach ($pdoStatement as $row) {
            $tab[] = $row;
        }
        return $tab;
    }

    /**
     * @param $etuid
     * @return array|null retourne la liste des notes agrégées
     */
    public function recupererNotesAgregees($etuid): ?array
    {
        $sql = "Select * from agregation a JOIN etudiantAgregation where etudid = :etudidTag";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values = array(
            "etudidTag" => $etuid,
        );
        $tab = array();
        try {
            $pdoStatement->execute($values);
        } catch (Exception $e) {
            return null;
        }
        foreach ($pdoStatement as $row) {
            $tab[] = (new AgregationRepository())->construireDepuisTableauSQL($row);
        }
        return $tab;
    }

    /**
     * @param string $nomRessource
     * @param int $idAgregation
     * @param float $coef
     * @return bool|null permet d'insérer dans la bd les données correspondant à la table ressource_Agregation
     */
    public function enregistrerRessourceAgregee(string $nomRessource, int $idAgregation, float $coef): ?bool
    {
        $sql = "INSERT INTO agregerRessource (nomRessource, idAgregation, coefficient) 
            VALUES (:nomRessourceTag, :idAgregationTag, :coefficientTag)";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values = array(
            "nomRessourceTag" => $nomRessource,
            "idAgregationTag" => $idAgregation,
            "coefficientTag" => $coef
        );
        $pdoStatement->execute($values);
        $objetFormatTableau = $pdoStatement->fetch();
        if ($objetFormatTableau == null) {
            return null;
        }
        return true;
    }

    /**
     * @param string $idAgregation
     * @param int $idAgregationAgregee
     * @param float $coef
     * @return bool|null permet d'insérer dans la bd les données agregation_AgregationAgregee
     */
    public function enregistrerAgregationAgregee(string $idAgregation, int $idAgregationAgregee, float $coef): ?bool
    {
        $sql = "INSERT INTO agregerAgregation (idAgregation, idAgregationAgregee, coefficient) 
            VALUES (:idAgregationTag, :idAgregationAgregeeTag, :coefficientTag)";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values = array(
            "idAgregationTag" => $idAgregation,
            "idAgregationAgregeeTag" => $idAgregationAgregee,
            "coefficientTag" => $coef
        );
        $pdoStatement->execute($values);
        $objetFormatTableau = $pdoStatement->fetch();
        if ($objetFormatTableau == null) {
            return null;
        }
        return true;
    }

    public function existeDansNoter($etudid, $nomRessource): ?array
    {
        $sql = "SELECT note FROM noter WHERE etudid = :etudidTag AND nomRessource = :nomRessourceTag";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values = array(
            "etudidTag" => $etudid,
            "nomRessourceTag" => $nomRessource,
        );
        $pdoStatement->execute($values);
        $result = $pdoStatement->fetch();
        return $result === false ? null : $result;
    }

    public function existeDansAgregationRessource($etudid, $idAgregation): ?array
    {
        $sql = "SELECT note FROM etudiantAgregation WHERE etudid = :etudidTag AND idAgregation = :idAgregationTag";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values = array(
            "etudidTag" => $etudid,
            "idAgregationTag" => $idAgregation,
        );
        $pdoStatement->execute($values);
        $result = $pdoStatement->fetch();
        return $result === false ? null : $result;
    }

    /**
     * @param $etudid
     * @param $idAgregation
     * @return mixed return la note d'un étudiant avec une agrégation donnée
     */
    public function getNoteEtudiantAgregation($etudid, $idAgregation) : float|null
    {
        $sql = "SELECT note FROM etudiantAgregation WHERE etudid = :etudidTag AND idAgregation = :idAgregationTag";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values = array(
            "etudidTag" => $etudid,
            "idAgregationTag" => $idAgregation,
        );
        $pdoStatement->execute($values);
        $result = $pdoStatement->fetchColumn();
        return $result !== false ? (float) $result : null;

    }

    /**
     * @return array return la liste des etudiants trié dans l'ordre decroissant par rapport à leur note d'une agrégation
     */
    public function triDecroissantNoteEtudiants($idAgregation) : ?array
    {
        $sql = "SELECT e.* FROM etudiant e LEFT JOIN etudiantAgregation a ON a.etudid = e.etudid AND a.idAgregation = :idAgregationTag ORDER BY a.note DESC;";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values = array(
            "idAgregationTag" => $idAgregation,
        );
        try {
            $pdoStatement->execute($values);
        }catch (Exception $e) {
            return null;
        }

        foreach ($pdoStatement as $row) {
            $tabEtudiants[] = $this->construireDepuisTableauSQL($row);
        }
        return $tabEtudiants;
    }

    /**
     * @param $idAgregation
     * @return array|null return la liste des etudiants trié dans l'ordre croissant par rapport à leur note d'une agrégation
     */
    public function triCroissantNoteEtudiants($idAgregation) : ?array
    {
        $sql = "SELECT e.* FROM etudiantAgregation ea RIGHT JOIN etudiant e ON e.etudid = ea.etudid AND idAgregation = :idAgregationTag ORDER BY 
                CASE WHEN note IS NULL THEN 1 ELSE 0 END, note ASC;";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values = array(
            "idAgregationTag" => $idAgregation,
        );
        try {
            $pdoStatement->execute($values);
        }catch (Exception $e) {
            return null;
        }
        foreach ($pdoStatement as $row) {
            $tabEtudiants[] = $this->construireDepuisTableauSQL($row);
        }
        return $tabEtudiants;
    }


    protected function getNomColonnes(): array
    {
        return ["etudid", "codenip", "civ", "nomEtu", "prenomEtu", "bac", "specialite", "rg_admis", "avis", "login"];
    }

    protected function formatTableauSQL(AbstractDataObject $objet): array
    {
        return array(
            "etudidTag" => $objet->getEtudid(),
            "codenipTag" => $objet->getCodenip(),
            "civTag" => $objet->getCiv(),
            "nomEtuTag" => $objet->getNomEtu(),
            "prenomEtuTag" => $objet->getPrenomEtu(),
            "bacTag" => $objet->getBac(),
            "specialiteTag" => $objet->getSpecialite(),
            "rg_admisTag" => $objet->getRgadmis(),
            "avisTag" => $objet->getAvis(),
            "loginTag" => $objet->getLogin(),
        );
    }

    public function ajouterEcoleFav($idEcoles, $idEtudiant)
    {
        foreach ($idEcoles as $idEcole){
            if (stripos($idEcole, "False") == false) {
                $sql = "INSERT IGNORE INTO ecoleFavoris (idEcole, idEtudiant) VALUES (:idEcoleTag, :idEtudiantTag)";
                $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
                $values = array("idEcoleTag" => $idEcole, "idEtudiantTag" => $idEtudiant);
                $pdoStatement->execute($values);
            } else {
                $sql = "DELETE FROM ecoleFavoris WHERE idEtudiant = :idEtudiantTag AND idEcole = :idEcoleTag";
                $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
                $nouvelle_chaine = str_replace("False", "", $idEcole);
                $values = array("idEtudiantTag" => $idEtudiant, "idEcoleTag" => $nouvelle_chaine);
                $pdoStatement->execute($values);
            }
        }
    }

    public function ajouterAvisEcole($avisTot , $idEtudiant)
    {
        foreach ($avisTot as $avis){
            $parti = explode("_", $avis);
            $sql = "UPDATE ecoleFavoris SET avis = :avisTag WHERE idEtudiant = :idEtudiantTag AND idEcole = :idEcole";
            $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
            $values = array("avisTag" => $parti[0], "idEtudiantTag" => $idEtudiant, "idEcole" => $parti[1]);
            $pdoStatement->execute($values);
        }
    }

    public function ajouterCommentaireEcole($commentaires , $idEtudiant)
    {
        foreach ((new EcoleRepository())->recupererEcoleFavoris($idEtudiant) as $ecoleFavoris){
            $sql = "UPDATE ecoleFavoris SET commentaire = :commentaireTag WHERE idEtudiant = :idEtudiantTag AND idEcole = :idEcole";
            $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
            $values = array("commentaireTag" => $commentaires[$ecoleFavoris->getIdEcole()], "idEtudiantTag" => $idEtudiant, "idEcole" => $ecoleFavoris->getIdEcole());
            $pdoStatement->execute($values);
        }
    }

    protected function estAI(): bool
    {
        return false;
    }
}