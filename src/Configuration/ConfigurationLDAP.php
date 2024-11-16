<?php

namespace App\Sae\Configuration;

use Exception;

class ConfigurationLDAP
{
    // Définition des attributs pour les paramètres LDAP
    private static string $ldapServer = "10.10.1.30";
    private static int $ldapPort = 389;

    private static ?\LDAP\Connection $ldapConnection = null;

    private static string $ldapBaseDN = "dc=info,dc=iutmontp,dc=univ-montp2,dc=fr";

    // Méthode pour établir la connexion LDAP
    public static function connecterServeur()
    {
        // Connexion au serveur LDAP
        self::$ldapConnection = ldap_connect("ldap://" . self::$ldapServer . ":" . self::$ldapPort);

        // Vérifier si la connexion est réussie
        if (!self::$ldapConnection) {
            throw new Exception("Impossible de se connecter au serveur LDAP.");
        }

        // Définir la version du protocole LDAP
        ldap_set_option(self::$ldapConnection, LDAP_OPT_PROTOCOL_VERSION, 3);

        return self::$ldapConnection;
    }

    public static function deconnecterServeur()
    {
        if (self::$ldapConnection) {
            ldap_close(self::$ldapConnection);
            self::$ldapConnection = null; // Réinitialiser la connexion
        }
    }

    public static function getLdapServer(): mixed
    {
        return self::$ldapServer;
    }

    public static function getLdapPort(): mixed
    {
        return self::$ldapPort;
    }

    /**
     * @return mixed
     */
    public static function getLdapConnection()
    {
        return self::$ldapConnection;
    }

    public static function getLdapBaseDN(): string
    {
        return self::$ldapBaseDN;
    }




}