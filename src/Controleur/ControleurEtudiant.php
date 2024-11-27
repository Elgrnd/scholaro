<?php

namespace App\Sae\Controleur;


use App\Sae\Configuration\ConfigurationLDAP;
use App\Sae\Configuration\ConfigurationSite;
use App\Sae\Lib\ConnexionUtilisateur;
use App\Sae\Lib\MessageFlash;
use App\Sae\Lib\MotDePasse;
use App\Sae\Modele\DataObject\Agregation;
use App\Sae\Modele\DataObject\Noter;
use App\Sae\Modele\Repository\AgregationRepository;
use App\Sae\Modele\Repository\EtudiantRepository;
use App\Sae\Modele\DataObject\Etudiant;
use App\Sae\Modele\Repository\NoterRepository;
use mysql_xdevapi\Exception;


class ControleurEtudiant extends ControleurGenerique
{

    /**
     * @return void afficher la liste des étudiants
     */
    public static function afficherListe(): void
    {
        if (!ConnexionUtilisateur::estAdministrateur()) {
            MessageFlash::ajouter("danger", "Vous n'avez pas les droits administrateurs");
            self::redirectionVersUrl("controleurFrontal.php");
            return;
        }
        $etudiants = (new EtudiantRepository())->recuperer();
        ControleurGenerique::afficherVue("vueGenerale.php", ["titre" => "Liste des étudiants", "cheminCorpsVue" => "etudiant/liste.php", "etudiants" => $etudiants, "agregations" => []]);

    }

    public static function afficherListeFiltre()
    {
        if (!ConnexionUtilisateur::estAdministrateur()) {
            MessageFlash::ajouter("danger", "Vous n'avez pas les droits administrateurs");
            self::redirectionVersUrl("controleurFrontal.php");
            return;
        }
        $etudiants = (new EtudiantRepository())->recuperer();
        $agregations = array();
        if (isset($_REQUEST['idAgregations'])) {
            foreach ($_REQUEST["idAgregations"] as $agregation) {
                $agregations[] = (new AgregationRepository())->recupererParClePrimaire($agregation);
            }
        }
        ControleurGenerique::afficherVue("vueGenerale.php", ["titre" => "Liste des étudiants", "cheminCorpsVue" => "etudiant/liste.php", "etudiants" => $etudiants, "agregations" => $agregations]);
    }

    public static function triDecroissant(): void
    {
        if (!ConnexionUtilisateur::estAdministrateur()) {
            MessageFlash::ajouter("danger", "Vous n'avez pas les droits administrateurs");
            self::redirectionVersUrl("controleurFrontal.php?action=afficherEtudiantPage");
            return;
        }

        if (isset($_REQUEST['idAgregation'])) {
            $agregations = array();
            foreach ($_REQUEST["idAgregations"] as $agregation) {
                $agregations[] = (new AgregationRepository())->recupererParClePrimaire($agregation);
            }
            $etudiants = (new EtudiantRepository())->triDecroissantNoteEtudiants($_REQUEST['idAgregation']);
            if ($etudiants != null) {
                ControleurGenerique::afficherVue("vueGenerale.php", ["titre" => "Liste des étudiants", "cheminCorpsVue" => "etudiant/liste.php", "etudiants" => $etudiants, "agregations" => $agregations]);
            } else {
                self::afficherListe();
            }
        } else {
            self::afficherListe();
        }
    }

    public static function triCroissant(): void
    {
        if (!ConnexionUtilisateur::estAdministrateur()) {
            MessageFlash::ajouter("danger", "Vous n'avez pas les droits administrateurs");
            self::redirectionVersUrl("controleurFrontal.php");
            return;
        }
        if (isset($_REQUEST['idAgregation'])) {
            $agregations = array();
            foreach ($_REQUEST["idAgregations"] as $agregation) {
                $agregations[] = (new AgregationRepository())->recupererParClePrimaire($agregation);
            }
            $etudiants = (new EtudiantRepository())->triCroissantNoteEtudiants($_REQUEST['idAgregation']);
            if ($etudiants != null) {
                ControleurGenerique::afficherVue("vueGenerale.php", ["titre" => "Liste des étudiants", "cheminCorpsVue" => "etudiant/liste.php", "etudiants" => $etudiants, "agregations" => $agregations]);
            } else {
                self::afficherListe();
            }
        } else {
            self::afficherListe();
        }
    }

    /**
     * @return void affiche les détails d'un étudiant
     * @throws \Exception
     */
    public static function afficherEtudiantPage(): void
    {
        if (!ConnexionUtilisateur::estConnecte()) {
            MessageFlash::ajouter("warning", "Vous n'êtes pas connectés");
            self::redirectionVersUrl("controleurFrontal.php");
            return;
        }
        if (!isset($_REQUEST['id'])) {
            self::afficherErreur("L'id de l'étudiant n'a pas été transmis");
            return;
        }
        $etudiant = (new EtudiantRepository())->recupererParClePrimaire($_REQUEST['id']);
        if (!$etudiant) {
            self::afficherErreur("Aucunes infos sur l'étudiant");
            return;
        }
        if (!ConfigurationSite::getDebug()) {
            ConfigurationLDAP::connecterServeur();
            if (!ConnexionUtilisateur::estUtilisateur(ConfigurationLDAP::getAvecUidNumber($_REQUEST['id'])) && !ConnexionUtilisateur::estAdministrateur()) {
                MessageFlash::ajouter("danger", "Les détails d'un étudiant ne peuvent être vu que par lui même et un administrateur.");
                self::redirectionVersUrl("controleurFrontal.php?action=afficherErreur");
                return;
            }
        }

        $notes = (new EtudiantRepository())->getNotesEtudiant($_REQUEST['id']);
        $notesAgregees = (new EtudiantRepository())->recupererNotesAgregees($_REQUEST['id']);
        ControleurGenerique::afficherVue("vueGenerale.php", ["titre" => "page Etudiant", "cheminCorpsVue" => "etudiant/etudiantPage.php", "etudiant" => $etudiant, "notes" => $notes, "notesAgregees" => $notesAgregees]);
    }

    public static function ajouterDepuisCSV(): void
    {
        if (!ConnexionUtilisateur::estAdministrateur()) {
            MessageFlash::ajouter("danger", "Importation uniquement possible pour un administrateur");
            self::redirectionVersUrl("controleurFrontal.php");
            return;
        }
        try {
            self::importerInfosEtudiant($_FILES);
            MessageFlash::ajouter("success", "Étudiants importés avec succès !");
            self::redirectionVersUrl("controleurFrontal.php?action=afficherListe");
        } catch (\Exception $e) {
            MessageFlash::ajouter("warning", "Erreur lors de l'importation des données");
            self::redirectionVersUrl("controleurFrontal.php?action=afficherListe");
        }
    }

    public static function importerInfosEtudiant(array $tableau): void
    {
        $filename = $tableau["file"]["tmp_name"];
        if ($tableau["file"]["size"] > 0) {
            $file = fopen($filename, "r");
            $header = fgetcsv($file, 10000, ',');

            if ($header[0] != "etudid") {
                throw new \Exception();
            }

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
    }

}