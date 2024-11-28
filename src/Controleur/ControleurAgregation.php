<?php

namespace App\Sae\Controleur;

use App\Sae\Lib\ConnexionUtilisateur;
use App\Sae\Lib\MessageFlash;
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
            MessageFlash::ajouter("danger", "Vous n'avez pas les droits administrateurs");
            self::redirectionVersUrl("controleurFrontal.php");
            return;
        }
        $agregations = (new AgregationRepository())->recuperer();
        foreach ($agregations as $agregation) {
            $listeRessources = (new AgregationRepository())->listeRessourcesAgregees($agregation->getIdAgregation());
            $listeAgregation = (new AgregationRepository())->listeAgregationsAgregees($agregation->getIdAgregation());
            if (empty($listeAgregation) && empty($listeRessources)) {
                (new AgregationRepository())->supprimer($agregation->getIdAgregation());
            }
        }
        ControleurGenerique::afficherVue("vueGenerale.php", ["titre" => "Liste des agregations", "cheminCorpsVue" => "agregation/liste.php", "agregations" => $agregations]);

    }

    /**
     * @return void affiche la compostion d'une agrégation
     */
    public static function afficherDetail(): void
    {
        if (!ConnexionUtilisateur::estAdministrateur()) {
            MessageFlash::ajouter("danger", "Vous n'avez pas les droits administrateurs");
            self::redirectionVersUrl("controleurFrontal.php");
            return;
        }
        if ($_REQUEST['id']) {
            $agregation = (new AgregationRepository())->recupererParClePrimaire($_REQUEST['id']);
            if ($agregation) {
                $listeRessources = (new AgregationRepository())->listeRessourcesAgregees($_REQUEST['id']);
                $listeAgregations = (new AgregationRepository())->listeAgregationsAgregees($_REQUEST['id']);
                ControleurGenerique::afficherVue("vueGenerale.php", ["titre" => "page Agrégation", "cheminCorpsVue" => "agregation/detail.php", "agregation" => $agregation, "listeRessources" => $listeRessources, "listeAgregations" => $listeAgregations]);
            } else {
                MessageFlash::ajouter("warning", "L'id n'est pas celle d'une agrégation");
                self::redirectionVersUrl("controleurFrontal.php?action=afficherListe&controleur=agregation");
            }
        } else {
            MessageFlash::ajouter("warning", "L'id de l'agrégation n'a pas été transmis");
            self::redirectionVersUrl("controleurFrontal.php?action=afficherListe&controleur=agregation");
        }
    }

    public static function supprimer(): void
    {
        $id = $_REQUEST['id'];

        if (!ConnexionUtilisateur::estAdministrateur()) {
            MessageFlash::ajouter("danger", "Vous n'avez pas les droits administrateurs");
            self::redirectionVersUrl("controleurFrontal.php");
            return;
        }
        (new AgregationRepository())->supprimer($id);
        MessageFlash::ajouter("success", "Agrégation supprimée");
        self::redirectionVersUrl("controleurFrontal.php?action=afficherListe&controleur=agregation");

    }

    /**
     * @return void affiche la vue formulaire de créer agrégation
     */
    public static function afficherFormulaire(): void
    {
        if (!ConnexionUtilisateur::estAdministrateur()) {
            MessageFlash::ajouter("danger", "Vous n'avez pas les droits administrateurs");
            self::redirectionVersUrl("controleurFrontal.php");
        } else {
            $agregations = (new AgregationRepository())->recuperer();
            $ressources = (new RessourceRepository())->recuperer();
            ControleurGenerique::afficherVue("vueGenerale.php", ['titre' => "creer agrégation", "cheminCorpsVue" => "agregation/agregationFormulaire.php", "agregations" => $agregations, "ressources" => $ressources]);
        }
    }

    public static function construireDepuisFormulaire(): void
    {
        if (!ConnexionUtilisateur::estAdministrateur()) {
            MessageFlash::ajouter("danger", "Vous n'avez pas les droits administrateurs");
            self::redirectionVersUrl("controleurFrontal.php");
            return;
        }

        $nomAgregation = $_REQUEST['nomAgregation'] ?? null;
        $count = $_REQUEST['count'] ?? 0;

        if (!$nomAgregation || !$count) {
            MessageFlash::ajouter("warning", "Vous avez oublié le nom de l'agrégation et/ou de sélectionner des ressources");
            self::redirectionVersUrl("controleurFrontal.php?action=afficherFormulaire&controleur=agregation");
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
            MessageFlash::ajouter("warning", "Aucune ressource ou agrégation n'a été enregistrée");
            self::redirectionVersUrl("controleurFrontal.php?action=afficherFormulaire&controleur=agregation");
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

        MessageFlash::ajouter("success", "Agrégation créée avec succès !");
        self::redirectionVersUrl('controleurFrontal.php?action=afficherDetail&controleur=agregation&id=' . $idAgregation);
    }

}