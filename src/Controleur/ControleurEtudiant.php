<?php

namespace App\Sae\Controleur;


use App\Sae\Lib\ConnexionUtilisateur;
use App\Sae\Lib\MotDePasse;
use App\Sae\Modele\DataObject\Agregation;
use App\Sae\Modele\Repository\AgregationRepository;
use App\Sae\Modele\Repository\EtudiantRepository;
use App\Sae\Modele\DataObject\Etudiant;


class ControleurEtudiant extends ControleurGenerique
{

    /**
     * @return void afficher la liste des étudiants
     */
    public static function afficherListe(): void
    {
        $etudiants = (new EtudiantRepository())->recuperer();

        ControleurGenerique::afficherVue("vueGenerale.php", ["titre" => "Liste des etudiants", "cheminCorpsVue" => "etudiant/liste.php", "etudiants" => $etudiants]);

    }

    /**
     * @return void affiche les détails d'un étudiant
     */
    public static function afficherEtudiantPage(): void
    {
        if (isset($_GET['id'])) {
            $etudiant = (new EtudiantRepository())->recupererParClePrimaire($_GET['id']);
            if ($etudiant) {
                $notes = (new EtudiantRepository())->getNotesEtudiant($_GET['id']);
                $notesAgregees = (new EtudiantRepository())->recupererNotesAgregees($_GET['id']);
                ControleurGenerique::afficherVue("vueGenerale.php", ["titre" => "page Etudiant", "cheminCorpsVue" => "etudiant/etudiantPage.php", "etudiant" => $etudiant, "notes" => $notes, "notesAgregees" => $notesAgregees]);
            } else {
                self::afficherErreur("L'id n'est pas celle d'un étudiant");
            }
        } else {
            self::afficherErreur("L'id de l'étudiant n'a pas été transmis");
        }
    }

    public static function creerAgregation()
    {
        if (isset($_REQUEST['nomAgregation'], $_REQUEST['etuid'])) {
            $diviseur = 0;
            $cumul = 0;
            for ($i = 0; $i < $_REQUEST['id']; $i++) {
                if (isset($_REQUEST['noteCheck' . $i]) && $_REQUEST['noteCheck' . $i] > 0) {
                    $cumul += ($_REQUEST['noteagreger' . $i] * $_REQUEST['coeff' . $i]);
                    $diviseur += $_REQUEST['coeff' . $i];
                }
            }
            if ($diviseur != 0) {
                $res = $cumul / $diviseur;
                $agregation = new Agregation(null, $_GET['nomAgregation'], $res, (new EtudiantRepository())->recupererParClePrimaire($_GET['etuid']));
                $idAgregation = (new AgregationRepository())->ajouter($agregation);
                $agregation->setIdAgregation($idAgregation);
                for ($i = 0 ; $i < $_REQUEST['id']; $i++){
                    if (isset($_REQUEST['noteCheck' . $i]) && $_REQUEST['noteCheck' . $i] > 0) {
                        if (ctype_digit($_REQUEST['idNom' . $i])) {
                            (new EtudiantRepository())->enregistrerAgregationAgregee($agregation->getIdAgregation(), $_REQUEST['idNom' . $i], $_REQUEST['coeff'.$i]);
                        } else {
                            (new EtudiantRepository())->enregistrerRessource($_REQUEST['idNom' . $i], $agregation->getIdAgregation(), $_REQUEST['coeff' . $i]);
                        }
                    }
                }
                $notes = (new EtudiantRepository())->getNotesEtudiant($agregation->getEtudiant()->getEtudid());
                $notesAgregees = (new EtudiantRepository())->recupererNotesAgregees($agregation->getEtudiant()->getEtudid());
                ControleurGenerique::afficherVue("vueGenerale.php", ["titre" => "page Etudiant", "cheminCorpsVue" => "etudiant/agregationCreee.php", "etudiant" => $agregation->getEtudiant(), "notes" => $notes, "notesAgregees" => $notesAgregees]);
            } else {
                self::afficherErreur("Aucune note sélectionnée");
            }
        } else {
            self::afficherErreur("Données manquantes");
        }
    }

    public static function supprimerAgregation(): void
    {
        if (isset($_GET["idNoteAgregee"])) {
            $test = (new AgregationRepository())->supprimer($_GET['idNoteAgregee']);
            if ($test) {
                $etudiant = (new EtudiantRepository())->recupererParClePrimaire($_GET['etudid']);
                $notes = (new EtudiantRepository())->getNotesEtudiant($etudiant->getEtudid());
                $notesAgregees = (new EtudiantRepository())->recupererNotesAgregees($etudiant->getEtudid());
                ControleurGenerique::afficherVue("vueGenerale.php", ["titre" => "page Etudiant", "cheminCorpsVue" => "etudiant/agregationSuppr.php", "etudiant" => $etudiant, "notes" => $notes, "notesAgregees" => $notesAgregees]);
            } else {
                self::afficherErreur("Agregation inconnu");
            }
        } else {
            self::afficherErreur("Données manquantes");
        }
    }

    /**
     * @param string $erreur message d'erreur à afficher
     * @return void afficher la page d'erreur
     */
    public static function afficherErreur(string $erreur = ""): void
    {
        ControleurGenerique::afficherVue("vueGenerale.php", ["titre" => "Erreur", "cheminCorpsVue" => "etudiant/erreur.php", "erreur" => $erreur]);
    }

    public static function ajouterDepuisCSV(): void
    {
        if (isset($_FILES["file"]) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $filename = $_FILES["file"]["tmp_name"];
            if ($_FILES["file"]["size"] > 0) {
                $file = fopen($filename, "r");
                $header = fgetcsv($file, 10000, ',');

                foreach ($header as $index => $colName) {
                    if ($colName === 'Nom') {
                        $header[$index] = 'Nom1';
                        break;
                    }
                }

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
                    $mdpHache = MotDePasse::hacher($ligne["code_nip"]);

                    if (!ctype_digit(substr($etudid, 0, 1))) {
                        break;
                    }

                    $etudiant = new Etudiant((int)$etudid, $code_nip, $civ, $nomEtu, $prenomEtu, $bac, $specialite, (int)$rg_admis, "", $mdpHache);
                    (new EtudiantRepository())->ajouter($etudiant);
                }
                fclose($file);
            }
            $etudiants = (new EtudiantRepository())->recuperer();
            ControleurGenerique::afficherVue("vueGenerale.php", ["titre" => "Etudiants importés avec succès", "cheminCorpsVue" => "etudiant/etudiantsImportes.php", "etudiants" => $etudiants]);
        } else {
            self::afficherErreur("Erreur lors de l'importation du fichier");
        }
    }

    public static function afficherFormulaireConnexion(): void
    {
        self::afficherVue("vueGenerale.php", ["titre" => "Connexion", "cheminCorpsVue" => "formulaireConnexion.php"]);
    }

    public static function connecter(): void
    {
        if (!isset($_REQUEST['login']) || !isset($_REQUEST['mdp'])) {
            self::afficherErreur("Login et/ou mot de passe manquant(s)");
            return;
        }

        $etudiant = (new EtudiantRepository())->recupererParClePrimaire($_REQUEST['login']);
        if ($etudiant === null || !\App\Sae\Lib\MotDePasse::verifier($_REQUEST['mdp'], $etudiant->getMdpHache())) {
            self::afficherErreur("Login et/ou mot de passe incorrect(s)");
            return;
        }

        ConnexionUtilisateur::connecter($etudiant->getEtudid());
        self::afficherVue("vueGenerale.php", ["titre" => "Connexion réussie !", "cheminCorpsVue" => "etudiant/etudiantConnecte.php", "etudiant" => $etudiant]);
    }

    public static function deconnecter(): void
    {
        ConnexionUtilisateur::deconnecter();
        $etudiants = (new EtudiantRepository())->recuperer();
        self::afficherVue("vueGenerale.php", ["titre" => "Déconnexion réussie !", "cheminCorpsVue" => "etudiant/etudiantDeconnecte.php", "etudiants" => $etudiants]);
    }

}