<?php

namespace App\Sae\Controleur;

use App\Sae\Lib\ConnexionUtilisateur;
use App\Sae\Modele\DataObject\Agregation;
use App\Sae\Modele\DataObject\Etudiant;
use App\Sae\Modele\Repository\AgregationRepository;
use App\Sae\Modele\Repository\EtudiantRepository;
use App\Sae\Modele\Repository\RessourceRepository;

class ControleurAgregation extends ControleurGenerique
{
    /**
     * @return void affiche la liste des agregations
     */
    public static function afficherListe(): void
    {
        if (!ConnexionUtilisateur::estAdministrateur()) {
            self::afficherErreur("Vous n'avez pas les droits administrateurs");
            return;
        }
        $agregations = (new AgregationRepository())->recuperer();
        ControleurGenerique::afficherVue("vueGenerale.php", ["titre" => "Liste des agregations", "cheminCorpsVue" => "agregation/liste.php", "agregations" => $agregations]);

    }

    /**
     * @return void affiche la compostion d'une agrégation
     */
    public static function afficherDetail(): void
    {
        if (!ConnexionUtilisateur::estAdministrateur()) {
            self::afficherErreur("Vous n'avez pas les droits administrateurs");
            return;
        }
        if ($_REQUEST['id']) {
            $agregation = (new AgregationRepository())->recupererParClePrimaire($_REQUEST['id']);
            if ($agregation) {
                /*$listeRessources = (new AgregationRepository())->listeRessourcesAgregees($agregation->getIdAgregation(), $agregation->getEtudiant()->getEtudid());
                $listeAgregations = (new AgregationRepository())->listeAgregationsAgregees($agregation->getIdAgregation());
                */
                ControleurGenerique::afficherVue("vueGenerale.php", ["titre" => "page Agrégation", "cheminCorpsVue" => "agregation/detail.php", "agregation" => $agregation/*, "listeRessources" => $listeRessources, "listeAgregations" => $listeAgregations*/]);
            } else {
                self::afficherErreur("L'id n'est pas celle d'une agrégation");
            }
        } else {
            self::afficherErreur("L'id de l'étudiant n'a pas été transmis");
        }
    }

    public static function afficherFormulaire(): void
    {
        if (!ConnexionUtilisateur::estAdministrateur()) {
            self::afficherErreur("Vous n'avez pas les droits administrateurs");
        } else {
            $agregations = (new AgregationRepository())->recuperer();
            $ressources = (new RessourceRepository())->recuperer();
            ControleurGenerique::afficherVue("vueGenerale.php", ['titre' => "creer agrégation", "cheminCorpsVue" => "agregation/agregationFormulaire.php", "agregations" => $agregations, "ressources" => $ressources]);
        }
    }

    public static function construireDepuisFormulaire(): void
    {
        if (!ConnexionUtilisateur::estAdministrateur()) {
            self::afficherErreur("Vous n'avez pas les droits administrateurs");
            return;
        }

        $nomAgregation = $_REQUEST['nomAgregation'] ?? null;
        $count = $_REQUEST['count'] ?? 0;

        if (!$nomAgregation || !$count) {
            self::afficherErreur("Vous avez oublié le nom de l'agrégation à créer et/ou de sélectionner des ressources");
            return;
        }

        $tabNom = [];
        $tabCoeff = [];

        for ($i = 0; $i < $count; $i++) {
            $coeff = $_REQUEST['coeff' . $i] ?? 0;
            if ($coeff > 0) {
                $tabNom[] = $_REQUEST['idNom' . $i];
                $tabCoeff[] = $coeff;
            }
        }

        if (empty($tabNom) || empty($tabCoeff)) {
            self::afficherErreur("Aucune ressource ou agrégation n'a été enregistrée");
            return;
        }

        $agregationRepo = new AgregationRepository();
        $etudiantRepo = new EtudiantRepository();

        // Création et enregistrement de l'agrégation
        $agregation = new Agregation(null, $nomAgregation);
        $idAgregation = $agregationRepo->ajouter($agregation);

        // Enregistrement des ressources/agregations liées
        foreach ($tabNom as $index => $nom) {
            if ($nom[0] === 'R') {
                $etudiantRepo->enregistrerRessourceAgregee($nom, $idAgregation, $tabCoeff[$index]);
            } else {
                $etudiantRepo->enregistrerAgregationAgregee($idAgregation, $nom, $tabCoeff[$index]);
            }
        }

        // Calcul et enregistrement des moyennes des étudiants
        $etudiants = $etudiantRepo->recuperer();
        foreach ($etudiants as $etudiant) {
            $moyenne = $etudiant->calculerMoyenne($tabNom, $tabCoeff);
            if ($moyenne != -1) {
                $agregationRepo->ajouterEtudiant($idAgregation, $etudiant->getEtudid(), $moyenne);
            }
        }

        // Récupération des agrégations pour affichage
        $agregations = $agregationRepo->recuperer();
        ControleurGenerique::afficherVue("vueGenerale.php", [
            "titre" => "Liste des agrégations",
            "cheminCorpsVue" => "agregation/liste.php",
            "agregations" => $agregations
        ]);
    }


    /**
     * @param string $erreur message d'erreur à afficher
     * @return void afficher la page d'erreur
     */
    public
    static function afficherErreur(string $erreur): void
    {
        ControleurGenerique::afficherVue("vueGenerale.php", ["titre" => "Erreur", "cheminCorpsVue" => "agregation/erreur.php", "erreur" => $erreur]);
    }
}