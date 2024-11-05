<?php

namespace App\Sae\Controleur;

use App\Sae\Lib\ConnexionUtilisateur;
use App\Sae\Lib\MotDePasse;
use App\Sae\Modele\DataObject\Professeur;
use App\Sae\Modele\Repository\ProfesseurRepository;

class ControleurProfesseur extends ControleurGenerique
{
    public static function connecter(): void
    {
        if (!isset($_REQUEST['login']) || !isset($_REQUEST['mdp'])) {
            self::afficherErreur("Login et/ou mot de passe manquant(s)");
            return;
        }

        $professeur = (new ProfesseurRepository())->recupererParClePrimaire($_REQUEST['login']);
        if ($professeur === null || !MotDePasse::verifier($_REQUEST['mdp'], $professeur->getMdpHache())) {
            self::afficherErreur("Login et/ou mot de passe incorrect(s)");
            return;
        }

        ConnexionUtilisateur::connecter($professeur->getLoginProf());
        self::afficherVue("vueGenerale.php", ["titre" => "Connexion réussie !", "cheminCorpsVue" => "etudiant/etudiantConnecte.php", "professeur" => $professeur]);
    }

    

    /**
     * @param string $erreur message d'erreur à afficher
     * @return void afficher la page d'erreur
     */
    public static function afficherErreur(string $erreur = ""): void
    {
        ControleurGenerique::afficherVue("vueGenerale.php", ["titre" => "Erreur", "cheminCorpsVue" => "professeur/erreur.php", "erreur" => $erreur]);
    }
}