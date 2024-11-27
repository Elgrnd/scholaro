<?php

namespace App\Sae\Lib;

use App\Sae\Modele\HTTP\Cookie;

class ChoixSemestre
{
    private static string $cleChoix = "choixSemestre";

    public static function enregistrer(array $choix) : void
    {
        Cookie::enregistrer(self::$cleChoix, $choix);
    }

    public static function lire() : array
    {
        return Cookie::lire(self::$cleChoix);
    }

    public static function existe() : bool
    {
        return Cookie::contient(self::$cleChoix);
    }

    public static function supprimer() : void
    {
        Cookie::supprimer(self::$cleChoix);
    }
}