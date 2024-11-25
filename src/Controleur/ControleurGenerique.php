<?php

namespace App\Sae\Controleur;

use App\Sae\Configuration\ConfigurationLDAP;
use App\Sae\Configuration\ConfigurationSite;
use App\Sae\Lib\ChoixControleur;
use App\Sae\Lib\ConnexionUtilisateur;

class ControleurGenerique
{

    /**
     * @param string $cheminVue Le chemin de la vue à utiliser
     * @param array $parametres des paramètres supplémentaire pour des informations spécifiques aux pages
     * @return void fonctions à appeler pour afficher une vue
     */
    protected static function afficherVue(string $cheminVue, array $parametres = []): void
    {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ . "/../vue/$cheminVue"; // Charge la vue
    }

    public static function afficherFormulaireConnexion(): void
    {
        if (ConnexionUtilisateur::estConnecte()) {
            return;
        }
        self::afficherVue("vueGenerale.php", ["titre" => "Connexion", "cheminCorpsVue" => "formulaireConnexion.php"]);
    }

    /**
     * @throws \Exception
     */
    public static function connecter(): void
    {

        if (ConfigurationSite::getDebug()) {
            ConnexionUtilisateur::connecter("desertg");
            self::afficherVue("vueGenerale.php", ["titre" => "Connexion réussie", "cheminCorpsVue" => "connecte.php"]);
            return;
        }

        if (!isset($_REQUEST['login']) || !isset($_REQUEST['mdp'])) {
            self::afficherErreur("Login et/ou mot de passe manquant(s)");
            return;
        }
       if($_SERVER["HTTP_HOST"] == "webinfo.iutmontp.univ-montp2.fr") {
           $ldapConnection = ConfigurationLDAP::connecterServeur();

           // Login / mot de passe ˋa tester
           $ldapLogin = $_REQUEST['login'];
           $ldapPassword = $_REQUEST['mdp'];

           // DN (distinguished name) de base ˋa l’IUT
           $ldapBaseDN = ConfigurationLDAP::getLdapBaseDN();

           // Filtre par uid (idenfiant unique)
           $ldapSearchFilter = "(uid=$ldapLogin)";
           $ldapSearch = ldap_search($ldapConnection, $ldapBaseDN, $ldapSearchFilter, array());

           // Recherche des utilisateurs avec cet identifiant
           $ldapUserResult = ldap_get_entries($ldapConnection, $ldapSearch);

           // Vérification que le login existe bien
           if ($ldapUserResult["count"] != 1) {
               self::afficherErreur("Utilisateur inconnu");
               return;
           }

           // Récupération du DN complet de l’utilisateur
           $ldapUserDN = $ldapUserResult[0]["dn"];

           // Tentative de connexion avec login / mdp
           // Le @ sert à éviter l’écriture d’un message de Warning en cas d’identifiants incorrects
           $ldapBindSuccessful = @ldap_bind($ldapConnection, $ldapUserDN, $ldapPassword);
           if ($ldapBindSuccessful) {
               ConnexionUtilisateur::connecter($ldapLogin);
               self::afficherVue("vueGenerale.php", ["titre" => "Connexion réussie", "cheminCorpsVue" => "connecte.php"]);
           } else {
               self::afficherErreur("Identifiants incorrects");
           }
       }else{
           self::afficherErreur("Connexion LDAP impossible");
       }
    }

    public static function deconnecter(): void
    {
        // Fermeture de la connection au LDAP
        ConnexionUtilisateur::deconnecter();
        ConfigurationLDAP::deconnecterServeur();
        self::afficherVue("vueGenerale.php", ["titre" => "Déconnexion réussie !", "cheminCorpsVue" => "deconnecte.php"]);
    }

    public static function afficherErreur(string $erreur = ""): void
    {
        ControleurGenerique::afficherVue("vueGenerale.php", ["titre" => "Erreur", "cheminCorpsVue" => "erreur.php", "erreur" => $erreur]);
    }
}