<?php

namespace App\Sae\Lib;

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

    public static function estUtilisateur($login): bool {
        return self::estConnecte() && self::getLoginUtilisateurConnecte() == $login;
    }

    public static function estAdministrateur() : bool {
        if (!self::estConnecte()) {
            return false;
        }
        $utilisateur = (new ProfesseurRepository())->recupererParClePrimaire(self::getLoginUtilisateurConnecte());
        if ($utilisateur == null) {
            return false;
        }
        return $utilisateur->isEstAdmin();
    }

    public static function estEtudiant() : bool
    {
        if (!self::estConnecte()) {
            return false;
        }
        $utilisateur = (new EtudiantRepository())->recupererParClePrimaire(self::getLoginUtilisateurConnecte());
        return $utilisateur != null;
    }
}