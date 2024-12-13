<?php

namespace App\Sae\Controleur;


use App\Sae\Lib\MessageFlash;
use App\Sae\Lib\MotDePasse;
use App\Sae\Lib\VerificationEmail;
use App\Sae\Modele\DataObject\Ecole;
use App\Sae\Modele\Repository\EcoleRepository;

class ControleurEcolePartenaire extends ControleurGenerique
{
    public static function afficherFormulaireCreationCompte()
    {
        ControleurGenerique::afficherVue("vueGenerale.php",["titre" => "Formulaire création de compte", "cheminCorpsVue" => "ecolePartenaire/formulaireCreationCompte.php"]);
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
            if(!$entreprise) {
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
            }else{
                MessageFlash::ajouter("warning", "Erreur l'entreprise existe déjà");
                self::redirectionVersUrl("controleurFrontal.php?action=afficherFormulaireCreationCompte");
            }
        } else {
            MessageFlash::ajouter("warning", "Données manquantes");
            self::redirectionVersUrl("controleurFrontal.php?action=afficherFormulaireCreationCompte");
        }
    }


}