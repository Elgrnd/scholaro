<?php

namespace App\Sae\Controleur;

use App\Sae\Exception\ArgNullException;
use App\Sae\Exception\DroitException;
use App\Sae\Lib\ConnexionUtilisateur;
use App\Sae\Lib\MessageFlash;
use App\Sae\Lib\Preferences;
use App\Sae\Modele\DataObject\Agregation;
use App\Sae\Modele\DataObject\Etudiant;
use App\Sae\Modele\Repository\AgregationRepository;
use App\Sae\Modele\Repository\EcoleRepository;
use App\Sae\Modele\Repository\EtudiantRepository;
use App\Sae\Modele\Repository\RessourceRepository;
use App\Sae\Service\ServiceAgregation;

class ControleurAgregation extends ControleurGenerique
{
    /**
     * @return void
     * affiche la liste des agregations
     */
    public static function afficherListe(): void
    {
        try {
            $login = ConnexionUtilisateur::getLoginUtilisateurConnecte();
            $agregations = (new ServiceAgregation())->recupererListe($login);
            ControleurGenerique::afficherVue("vueGenerale.php", ["titre" => "Liste des agregations", "cheminCorpsVue" => "agregation/liste.php", "agregations" => $agregations]);
        }
        catch (DroitException $e){
            MessageFlash::ajouter("danger", $e->getMessage());
            self::redirectionVersUrl("controleurFrontal.php");
        }
    }

    /**
     * @return void
     * affiche la compostion d'une agrégation
     */
    public static function afficherDetail(): void
    {
        try {
            $details = (new ServiceAgregation())->detail($_REQUEST['id']);

            // Affichage de la vue
            self::afficherVue("vueGenerale.php", [
                "titre" => "Page Agrégation",
                "cheminCorpsVue" => "agregation/detail.php",
                "agregation" => $details['agregation'],
                "listeRessources" => $details['listeRessources'],
                "listeAgregations" => $details['listeAgregations'],
                "moyenne" => $details['moyenne']
            ]);
        } catch (DroitException $e) {
            MessageFlash::ajouter("danger", $e->getMessage());
            self::redirectionVersUrl("controleurFrontal.php");
        } catch (ArgNullException $e) {
            MessageFlash::ajouter("warning", $e->getMessage());
            self::redirectionVersUrl("controleurFrontal.php?action=afficherListe&controleur=agregation");
        }
    }

    /**
     * @return void
     * affiche la vue liste agregation et appelle la méthode supprimer
     * */
    public static function supprimer(): void
    {
        $id = $_REQUEST['id'];

        if (!ConnexionUtilisateur::estAdministrateur() && !ConnexionUtilisateur::estEcolePartenaire(ConnexionUtilisateur::getLoginUtilisateurConnecte())) {
            MessageFlash::ajouter("danger", "Vous n'avez pas les droits administrateurs");
            self::redirectionVersUrl("controleurFrontal.php");
            return;
        }
        (new AgregationRepository())->supprimer($id);
        MessageFlash::ajouter("success", "Agrégation supprimée");
        self::redirectionVersUrl("controleurFrontal.php?action=afficherListe&controleur=agregation");

    }

    /**
     * @return void
     * affiche la vue formulaire de créer agrégation
     */
    public static function afficherFormulaire(): void
    {
        $login = ConnexionUtilisateur::getLoginUtilisateurConnecte();
        if (!ConnexionUtilisateur::estAdministrateur() && !ConnexionUtilisateur::estEcolePartenaire($login)) {
            MessageFlash::ajouter("danger", "Vous n'avez pas les droits administrateurs");
            self::redirectionVersUrl("controleurFrontal.php");
        } else {
            if (ConnexionUtilisateur::estEcolePartenaire($login)){
                $agregations = (new AgregationRepository())->recupererParUtilisateur($login);
            } else {
                $agregations = (new AgregationRepository())->recupererParUtilisateur("prof");
            }
            $ressources = (new RessourceRepository())->recuperer();
            ControleurGenerique::afficherVue("vueGenerale.php", ['titre' => "creer agrégation", "cheminCorpsVue" => "agregation/agregationFormulaire.php", "agregations" => $agregations, "ressources" => $ressources]);
        }
    }

    /**
     * @return void
     * Permet de
     */
    public static function construireDepuisFormulaire(): void
    {
        if (!ConnexionUtilisateur::estAdministrateur() && !ConnexionUtilisateur::estEcolePartenaire(ConnexionUtilisateur::getLoginUtilisateurConnecte())) {
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

        //LE LOGIN EST TEMPORAIRE, IL SERA CHANGE DES QU ON AURA LA CONNEXION PROF ET ECOLE PARTENAIRE
        $loginCreateur = null;
        $siretCreateur = null;
        if (ConnexionUtilisateur::estAdministrateur()){
            $loginCreateur = "prof";
        }
        if (ConnexionUtilisateur::estEcolePartenaire(ConnexionUtilisateur::getLoginUtilisateurConnecte())){
            $siretCreateur = ConnexionUtilisateur::getLoginUtilisateurConnecte();
        }
        $agregation = new Agregation(null, $nomAgregation, $loginCreateur, $siretCreateur);
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