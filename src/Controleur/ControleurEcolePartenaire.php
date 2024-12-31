<?php

namespace App\Sae\Controleur;


use App\Sae\Lib\ConnexionUtilisateur;
use App\Sae\Lib\MessageFlash;
use App\Sae\Lib\MotDePasse;
use App\Sae\Lib\Preferences;
use App\Sae\Lib\VerificationEmail;
use App\Sae\Modele\DataObject\Ecole;
use App\Sae\Modele\Repository\AgregationRepository;
use App\Sae\Modele\Repository\EcoleRepository;
use App\Sae\Modele\Repository\EtudiantRepository;

class ControleurEcolePartenaire extends ControleurGenerique
{
    public static function afficherFormulaireCreationCompte()
    {
        ControleurGenerique::afficherVue("vueGenerale.php", ["titre" => "Formulaire création de compte", "cheminCorpsVue" => "ecolePartenaire/formulaireCreationCompte.php"]);
    }

    public static function afficherListe()
    {
        $agregations = (new EcoleRepository())->recupererAgregations(ConnexionUtilisateur::getLoginUtilisateurConnecte());
        $etudiants = [];

        if ($agregations) {
            foreach ($agregations as $agregation) {
                $listeEtudiants = (new AgregationRepository())->recupererEtudiants($agregation->getIdAgregation());
                foreach ($listeEtudiants as $etudiant) {
                    $etudiants[$etudiant->getIdEtudiant()] = $etudiant;
                }
            }
        }
        ControleurGenerique::afficherVue("vueGenerale.php", ["titre" => "Liste des étudiants", "cheminCorpsVue" => "etudiant/liste.php", "etudiants" => $etudiants, "agregations" => $agregations]);
    }


    private static function construireDepuisFormulaire(array $tableauDonneesFormulaire): Ecole
    {
        $mdpHache = MotDePasse::hacher($tableauDonneesFormulaire['mdp']);
        $estValide = false;

        return new Ecole(
            $tableauDonneesFormulaire['siret'],
            $tableauDonneesFormulaire['nomEcole'],
            $tableauDonneesFormulaire['villeEcole'],
            $tableauDonneesFormulaire['tel'],
            $tableauDonneesFormulaire['email'],
            $tableauDonneesFormulaire['emailAValider'] ?? null,
            MotDePasse::genererChaineAleatoire(32), // Génération aléatoire pour le nonce.
            $estValide,
            $mdpHache
        );
    }

    public static function creerDepuisFormulaire(): void
    {
        // Vérification que toutes les données nécessaires sont présentes
        if (isset($_REQUEST["siret"], $_REQUEST["nomEcole"], $_REQUEST["villeEcole"], $_REQUEST["tel"], $_REQUEST["email"], $_REQUEST["mdp"], $_REQUEST["mdp2"])) {
            // Validation du format de l'email
            $entreprise = (new EcoleRepository())->recupererParClePrimaire($_REQUEST["siret"]);
            if (!$entreprise) {
                if (filter_var($_REQUEST["email"], FILTER_VALIDATE_EMAIL)) {
                    // Vérification des mots de passe
                    if ($_REQUEST["mdp"] === $_REQUEST["mdp2"]) {
                        // Construction de l'objet Ecole

                        $mdpHache = MotDePasse::hacher($_REQUEST['mdp']);
                        $estValide = false;

                        $ecole = new Ecole(
                            $_REQUEST['siret'],
                            $_REQUEST['nomEcole'],
                            $_REQUEST['villeEcole'],
                            $_REQUEST['tel'],
                            "",
                            $_REQUEST['email'],
                            MotDePasse::genererChaineAleatoire(32), // Génération aléatoire pour le nonce.
                            $estValide,
                            $mdpHache
                        );

                        // Ajout à la base de données
                        $test = (new EcoleRepository())->ajouter($ecole);

                        VerificationEmail::envoiEmailValidation($ecole);
                        MessageFlash::ajouter("success", "Compte créé !");
                        self::redirectionVersUrl("controleurFrontal.php?action=afficherFormulaireConnexion");
                    } else {
                        MessageFlash::ajouter("warning", "Les mots de passe ne correspondent pas");
                        self::redirectionVersUrl("controleurFrontal.php?action=afficherFormulaireCreationCompte");
                    }
                } else {
                    MessageFlash::ajouter("warning", "Format d'email invalide");
                    self::redirectionVersUrl("controleurFrontal.php?action=afficherFormulaireCreationCompte");
                }
            } else {
                MessageFlash::ajouter("warning", "Erreur l'entreprise existe déjà");
                self::redirectionVersUrl("controleurFrontal.php?action=afficherFormulaireCreationCompte");
            }
        } else {
            MessageFlash::ajouter("warning", "Données manquantes");
            self::redirectionVersUrl("controleurFrontal.php?action=afficherFormulaireCreationCompte");
        }
    }

    public static function validerEmail()
    {
        if (isset($_REQUEST['login']) && isset($_REQUEST['nonce'])) {
            $booleen = VerificationEmail::traiterEmailValidation($_REQUEST['login'], $_REQUEST['nonce']);
            if ($booleen === true) {
                $utilisateur = (new EcoleRepository())->recupererParClePrimaire($_REQUEST['login']);
                MessageFlash::ajouter("success", "Mail validé");
                ControleurGenerique::redirectionVersUrl("controleurFrontal.php");
            } else {
                self::afficherErreur("pb avec l'email");
            }
        } else {
            self::afficherErreur("erreur login ou nonce");
        }
    }


}