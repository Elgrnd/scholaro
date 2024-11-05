<?php

namespace App\Sae\Lib;

use App\Sae\Modele\HTTP\Cookie;

class ChoixControleur
{
    private static string $clePreference = "choixControleur";

    public static function enregistrer(string $preference) : void
    {
        Cookie::enregistrer(ChoixControleur::$clePreference, $preference);
    }

    public static function lire() : string
    {
        return Cookie::lire(ChoixControleur::$clePreference);
    }

    public static function existe() : bool
    {
        return Cookie::contient(ChoixControleur::$clePreference);
    }

    public static function supprimer() : void
    {
        Cookie::supprimer(ChoixControleur::$clePreference);
    }
}