<?php

namespace App\Sae\Modele\HTTP;

class Cookie
{
    public static function enregistrer(string $cle, mixed $valeur, ?int $dureeExpiration = null): void {
        $valeur = serialize($valeur);

        if ($dureeExpiration !== null) {
            setcookie($cle, $valeur, time() + $dureeExpiration);
        } else {
            setcookie($cle, $valeur);
        }
    }

    public static function lire(string $cle): mixed {
        if (isset($_COOKIE[$cle])) {
            return unserialize($_COOKIE[$cle]);
        } else {
            return null;
        }
    }

    public static function contient($cle): bool {
        return isset($_COOKIE[$cle]);
    }

    public static function supprimer($cle): void {
        unset($_COOKIE[$cle]);
    }
}