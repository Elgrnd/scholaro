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

    private static function afficherVue(string $cheminVue,   array $parametres = []): void
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

    }

}