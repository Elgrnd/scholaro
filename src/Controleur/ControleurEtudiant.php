<?php

namespace App\Sae\Controleur;


use App\Sae\Modele\Repository\EtudiantRepository;
use App\Sae\Modele\DataObject\Etudiant;

class ControleurEtudiant
{
    /**
     * @param string $cheminVue Le chemin de la vue à utiliser
     * @param array $parametres des paramètres supplémentaire pour des informations spécifiques aux pages
     * @return void fonctions à appeler pour afficher une vue
     */

    private static function afficherVue(string $cheminVue, array $parametres = []): void
    {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ . "/../vue/$cheminVue"; // Charge la vue
    }

    /**
     * @return void afficher la liste des étudiants
     */
    public static function afficherListe(): void
    {
        $etudiants = (new EtudiantRepository())->recuperer();
        if (empty($etudiants)) {
            self::afficherErreur("Aucun étudiant à afficher");
        } else {
            self::afficherVue("vueGenerale.php", ["titre" => "Liste des etudiants", "cheminCorpsVue" => "etudiant/afficherListe.php", "etudiants" => $etudiants]);
        }
    }

    /**
     * @param string $erreur message d'erreur à afficher
     * @return void afficher la page d'erreur
     */
    public static function afficherErreur(string $erreur): void
    {
        self::afficherVue("vueGenerale.php", ["titre" => "Erreur", "cheminCorpsVue" => "etudiant/erreur.php", "erreur" => $erreur]);
    }

    public static function afficherVueImportation(): void
    {
        self::afficherVue("vueGenerale.php", ["titre" => "Importer des étudiants", "cheminCorpsVue" => "etudiant/vueImportationCSV.php"]);
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

                    if ($etudid == "") {
                        break;
                    }

                    $etudiant = new Etudiant((int)$etudid, $code_nip, $civ, $nomEtu, $prenomEtu, $bac, $specialite, (int)$rg_admis, "");
                    (new EtudiantRepository())->ajouter($etudiant);
                }
                fclose($file);
            }
            $etudiants = (new EtudiantRepository())->recuperer();
            self::afficherVue("vueGenerale.php", ["titre" => "Etudiants importés avec succès", "cheminCorpsVue" => "etudiant/etudiantsImportes.php", "etudiants" => $etudiants]);
        } else {
            self::afficherErreur("Erreur lors de l'importation du fichier");
        }
    }

}