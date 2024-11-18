<?php

namespace App\Sae\Lib;

use App\Sae\Configuration\ConfigurationLDAP;
use App\Sae\Modele\HTTP\Session;
use App\Sae\Modele\Repository\EtudiantRepository;
use App\Sae\Modele\Repository\ProfesseurRepository;

class ConnexionUtilisateur
{
    // L'utilisateur connecté sera enregistré en session associé à la clé suivante
    private static string $cleConnexion = "_utilisateurConnecte";

    public static function connecter(string $loginUtilisateur): void
    {
        $session = Session::getInstance();
        $session->enregistrer(ConnexionUtilisateur::$cleConnexion, $loginUtilisateur);
    }

    public static function estConnecte(): bool
    {
        $session = Session::getInstance();
        return $session->contient(ConnexionUtilisateur::$cleConnexion);
    }

    public static function deconnecter(): void
    {
        $session = Session::getInstance();
        $session->supprimer(ConnexionUtilisateur::$cleConnexion);
    }

    public static function getLoginUtilisateurConnecte(): ?string
    {
        return $_SESSION[ConnexionUtilisateur::$cleConnexion];
    }

    public static function estUtilisateur($login): bool
    {
        return self::estConnecte() && self::getLoginUtilisateurConnecte() == $login;
    }

    public static function estAdministrateur(): bool
    {
        if (!self::estConnecte()) {
            return false;
        }
        return self::estUtilisateur("tordeuxm")
            || self::estUtilisateur("lyfoungn")
            || self::estUtilisateur("laurentg")
            || self::estUtilisateur("nedjary")
            || (self::estUtilisateur("messaoui"));
    }

    /**
     * @throws \Exception
     */
    public static function estEtudiant(): bool
    {
        if (!self::estConnecte()) {
            return false;
        }
        ConfigurationLDAP::connecterServeur();
        foreach (ConfigurationLDAP::getAll() as $etudiant) {
            if ($etudiant['login'] == self::getLoginUtilisateurConnecte() && ($etudiant['promotion'] == 'Ann1'
                    || $etudiant['promotion'] == 'Ann2'
                    || $etudiant['promotion'] == 'Ann3')) {
                return true;
            }
        }
        return false;
    }

    public static function estProfesseur(): bool
    {
        if (!self::estConnecte()) {
            return false;
        }
        ConfigurationLDAP::connecterServeur();
        foreach (ConfigurationLDAP::getAll() as $professeur) {
            if ($professeur['login'] == self::getLoginUtilisateurConnecte() && $professeur['promotion'] == 'Personnel') {
                return true;
            }
        }
        return false;
    }
}