<?php

namespace App\Sae\Controleur;


use App\Sae\Modele\DataObject\Agregation;
use App\Sae\Modele\Repository\AgregationRepository;
use App\Sae\Modele\Repository\EtudiantRepository;


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
     * @return void affiche les détails d'un étudiant
     */
    public static function afficherEtudiantPage(): void
    {
        if (isset($_GET['id'])) {
            $etudiant = (new EtudiantRepository())->recupererParClePrimaire($_GET['id']);
            if ($etudiant) {
                $notes = (new EtudiantRepository())->getNotesEtudiant($_GET['id']);
                self::afficherVue("vueGenerale.php", ["titre" => "page Etudiant", "cheminCorpsVue" => "etudiant/etudiantPage.php", "etudiant" => $etudiant, "notes"=> $notes]);
            }else{
                self::afficherErreur("L'id n'est pas celle d'un étudiant");
            }
        }else{
            self::afficherErreur("L'id de l'étudiant n'a pas été transmis");
        }
    }

    public static function creerAgregation()
    {
        if(isset($_GET['nomAgregation'], $_GET['etuid'])) {
            $diviseur = 0;
            $cumul = 0;
            for ($i = 0; $i < $_GET['id']; $i++) {
                if (isset($_GET['noteCheck' . $i])) {
                    $cumul += $_GET['noteagreger' . $i];
                    $diviseur += 1;
                }
            }
            if ($diviseur != 0) {
                $res = $cumul / $diviseur;
                $agregation = new Agregation(null, $_GET['nomAgregation'], $res, (new EtudiantRepository())->recupererParClePrimaire($_GET['etuid']));
                (new AgregationRepository())->ajouter($agregation);
                $notes = (new EtudiantRepository())->getNotesEtudiant($agregation->getEtudiant()->getEtudid());
                self::afficherVue("vueGenerale.php", ["titre" => "page Etudiant", "cheminCorpsVue" => "etudiant/agregationCreee.php", "etudiant" => $agregation->getEtudiant(), "notes"=> $notes]);
            }else{
                self::afficherErreur("Aucune note sélectionnée");
            }
        }else{
            self::afficherErreur("Données manquantes");
        }
    }

    private static function construireDepuisFormulaire(array $tableauDonneesFormulaire): Trajet{
        var_dump($tableauDonneesFormulaire);
        $id = $tableauDonneesFormulaire["id"] ?? null;
        echo $id;
        return new Trajet($id, $tableauDonneesFormulaire['depart'], $tableauDonneesFormulaire['arrivee'], new DateTime($tableauDonneesFormulaire['date']), $tableauDonneesFormulaire['prix'], (new UtilisateurRepository())->recupererParClePrimaire($tableauDonneesFormulaire['conducteurLogin']), ($tableauDonneesFormulaire["nonFumeur"]));
    }

    /**
     * @param string $erreur message d'erreur à afficher
     * @return void afficher la page d'erreur
     */
    public static function afficherErreur(string $erreur): void
    {
        self::afficherVue("vueGenerale.php", ["titre" => "Erreur", "cheminCorpsVue" => "etudiant/erreur.php", "erreur" => $erreur]);
    }

}