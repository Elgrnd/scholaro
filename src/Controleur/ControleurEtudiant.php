<?php

namespace App\Sae\Controleur;


use App\Sae\Configuration\ConfigurationLDAP;
use App\Sae\Lib\ConnexionUtilisateur;
use App\Sae\Lib\MotDePasse;
use App\Sae\Modele\DataObject\Agregation;
use App\Sae\Modele\DataObject\Noter;
use App\Sae\Modele\Repository\AgregationRepository;
use App\Sae\Modele\Repository\EtudiantRepository;
use App\Sae\Modele\DataObject\Etudiant;
use App\Sae\Modele\Repository\NoterRepository;


class ControleurEtudiant extends ControleurGenerique
{

    /**
     * @return void afficher la liste des étudiants
     */
    public static function afficherListe(): void
    {
        if (!ConnexionUtilisateur::estAdministrateur()) {
            self::afficherErreur("Vous n'avez pas les droits administrateurs");
            return;
        }
        $etudiants = (new EtudiantRepository())->recuperer();
        ControleurGenerique::afficherVue("vueGenerale.php", ["titre" => "Liste des étudiants", "cheminCorpsVue" => "etudiant/liste.php", "etudiants" => $etudiants, "agregations" => []]);

    }

    public static function afficherListeFiltre()
    {
        if (!ConnexionUtilisateur::estAdministrateur()) {
            self::afficherErreur("Vous n'avez pas les droits administrateurs");
            return;
        }
        $etudiants = (new EtudiantRepository())->recuperer();
        $agregations = array();
        if (isset($_REQUEST['idAgregations'])){
            foreach ($_REQUEST["idAgregations"] as $agregation){
                $agregations[] = (new AgregationRepository())->recupererParClePrimaire($agregation);
            }
        }
        ControleurGenerique::afficherVue("vueGenerale.php", ["titre" => "Liste des étudiants", "cheminCorpsVue" => "etudiant/liste.php", "etudiants" => $etudiants, "agregations" => $agregations]);
    }

    public static function triDecroissant(): void
    {
        if (!ConnexionUtilisateur::estAdministrateur()) {
            self::afficherErreur("Vous n'avez pas les droits administrateurs");
            return;
        }

        if (isset($_REQUEST['idAgregation'])) {
            $agregations = array();
            foreach ($_REQUEST["idAgregations"] as $agregation){
                $agregations[] = (new AgregationRepository())->recupererParClePrimaire($agregation);
            }
            $etudiants = (new EtudiantRepository())->triDecroissantNoteEtudiants($_REQUEST['idAgregation']);
            if ($etudiants != null) {
                ControleurGenerique::afficherVue("vueGenerale.php", ["titre" => "Liste des étudiants", "cheminCorpsVue" => "etudiant/liste.php", "etudiants" => $etudiants, "agregations" => $agregations]);
            }else{
                self::afficherListe();
            }
        } else {
            self::afficherListe();
        }
    }

    public static function triCroissant(): void
    {
        if (!ConnexionUtilisateur::estAdministrateur()) {
            self::afficherErreur("Vous n'avez pas les droits administrateurs");
            return;
        }
        if (isset($_REQUEST['idAgregation'])) {
            $agregations = array();
            foreach ($_REQUEST["idAgregations"] as $agregation){
                $agregations[] = (new AgregationRepository())->recupererParClePrimaire($agregation);
            }
            $etudiants = (new EtudiantRepository())->triCroissantNoteEtudiants($_REQUEST['idAgregation']);
            if ($etudiants != null) {
                ControleurGenerique::afficherVue("vueGenerale.php", ["titre" => "Liste des étudiants", "cheminCorpsVue" => "etudiant/liste.php", "etudiants" => $etudiants, "agregations" => $agregations]);
            }else{
                self::afficherListe();
            }
        } else {
            self::afficherListe();
        }
    }

    /**
     * @return void affiche les détails d'un étudiant
     */
    public static function afficherEtudiantPage(): void
    {
        if (!ConnexionUtilisateur::estConnecte()) {
            self::afficherErreur("Vous n'êtes pas connectés");
            return;
        }
        if (!isset($_GET['id'])) {
            self::afficherErreur("L'id de l'étudiant n'a pas été transmis");
            return;
        }
        $etudiant = (new EtudiantRepository())->recupererParClePrimaire($_GET['id']);
        if (!$etudiant) {
            self::afficherErreur("L'id n'est pas celle d'un étudiant");
            return;
        }
        if (!ConnexionUtilisateur::estUtilisateur($etudiant->getEtudid()) && !ConnexionUtilisateur::estAdministrateur()) {
            self::afficherErreur("Les détails d'un étudiant ne peuvent être vu que par lui même et un administrateur.");
            return;
        }
        $notes = (new EtudiantRepository())->getNotesEtudiant($_GET['id']);
        $notesAgregees = (new EtudiantRepository())->recupererNotesAgregees($_GET['id']);
        ControleurGenerique::afficherVue("vueGenerale.php", ["titre" => "page Etudiant", "cheminCorpsVue" => "etudiant/etudiantPage.php", "etudiant" => $etudiant, "notes" => $notes, "notesAgregees" => $notesAgregees]);
    }

    public static function ajouterDepuisCSV(): void
    {
        if (!ConnexionUtilisateur::estAdministrateur()) {
            self::afficherErreur("Uniquement disponible pour un administrateur.");
            return;
        }
        try {
            self::importerInfosEtudiant($_FILES);
            $etudiants = (new EtudiantRepository())->recuperer();
            ControleurGenerique::afficherVue("vueGenerale.php", ["titre" => "Etudiants importés avec succès", "cheminCorpsVue" => "etudiant/etudiantsImportes.php", "etudiants" => $etudiants]);
        } catch (\Exception $e) {
            self::afficherErreur("Erreur lors de l'importation du fichier");
        }
    }

    public static function importerInfosEtudiant(array $tableau): void
    {
        if (isset($tableau["file"]) && $tableau['file']['error'] === UPLOAD_ERR_OK) {
            $filename = $tableau["file"]["tmp_name"];
            if ($tableau["file"]["size"] > 0) {
                $file = fopen($filename, "r");
                $header = fgetcsv($file, 10000, ',');

                foreach ($header as $index => $colName) {
                    if ($colName === 'Nom') {
                        $header[$index] = 'Nom1';
                        break;
                    }
                }

                $etudiants = [];
                $notesRessources = [];
                while (($data = fgetcsv($file, 10000, ",")) !== FALSE) {
                    $ligne = array_combine($header, $data);

                    $etudid = $ligne["etudid"];
                    $code_nip = $ligne["code_nip"];
                    $civ = $ligne["Civ."];
                    $nomEtu = $ligne["Nom1"];
                    $prenomEtu = $ligne["Prénom"];
                    $bac = $ligne["Bac"];
                    $specialite = $ligne["Spécialité"];
                    $rg_admis = $ligne["Rg. Adm."];

                    if (!ctype_digit(substr($etudid, 0, 1))) {
                        break;
                    }

                    $etudiant = new Etudiant((int)$etudid, $code_nip, $civ, $nomEtu, $prenomEtu, $bac, $specialite, (int)$rg_admis, "");
                    $etudiants[] = $etudiant;

                    foreach ($header as $index => $colName) {
                        if (str_starts_with($colName, "R")) {
                            if (strlen($colName) > 1) {
                                $semestre = $colName[1];
                                if (!ctype_digit($semestre)) {
                                    continue;
                                }
                                if ($ligne[$colName] === "" || $ligne[$colName] === "~") {
                                    continue;
                                }
                                $note = $ligne[$colName];

                                $noteRessource = new Noter($etudid, $semestre, $colName, $note);
                                $notesRessources[] = $noteRessource;

                                (new EtudiantRepository())->enregistrerRessource($colName);
                            }
                        }
                    }
                }
                fclose($file);
                (new EtudiantRepository())->ajouterPlusieurs($etudiants);
                (new NoterRepository())->ajouterPlusieurs($notesRessources);
            }
        } else {
            self::afficherErreur("Erreur lors de l'importation du fichier");
        }
    }

}