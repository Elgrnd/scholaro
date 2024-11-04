<?php

namespace APP\Sae\Modele\HTTP;

use App\Sae\Configuration\ConfigurationBaseDeDonnees;
use App\Sae\Configuration\ConfigurationSite;
use App\Sae\Modele\HTTP\Cookie;
use Exception;

class Session
{
    private static ?\App\Sae\Modele\HTTP\Session $instance = null;

    /**
     * @throws Exception
     */
    private function __construct()
    {
        if (session_start() === false) {
            throw new Exception("La session n'a pas réussi à démarrer.");
        }
    }

    public static function getInstance(): Session
    {
        if (is_null(Session::$instance)) {
            Session::$instance = new Session();
        }
        self::verifierDerniereActivite();
        return Session::$instance;
    }

    public static function verifierDerniereActivite(): void
    {
        if (isset($_SESSION['derniereActivite']) && (time() - $_SESSION['derniereActivite'] > (ConfigurationSite::getTempsExpiration())))
            session_unset();     // unset $_SESSION variable for the run-time
        $_SESSION['derniereActivite'] = time(); // update last activity time stamp
    }

    public function contient($nom): bool
    {
        return isset($_SESSION[$nom]);
    }

    public function enregistrer(string $nom, mixed $valeur): void
    {
        $_SESSION[$nom] = $valeur;
    }

    public function lire(string $nom): mixed
    {
        if (isset($_SESSION[$nom])) {
            return $_SESSION[$nom];
        } else {
            return null;
        }
    }

    public function supprimer($nom): void
    {
        unset($_SESSION[$nom]);
    }

    public function detruire(): void
    {
        session_unset();     // unset $_SESSION variable for the run-time
        session_destroy();   // destroy session data in storage
        Cookie::supprimer(session_name()); // deletes the session cookie
// Il faudra reconstruire la session au prochain appel de getInstance()
        Session::$instance = null;
    }
}