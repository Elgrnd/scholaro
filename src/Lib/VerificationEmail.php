<?php

namespace App\Sae\Lib;

use App\Sae\Configuration\ConfigurationSite;
use App\Sae\Modele\DataObject\Ecole;
use App\Sae\Modele\Repository\EcoleRepository;

class VerificationEmail
{
    public static function envoiEmailValidation(Ecole $utilisateur): void
    {
        $destinataire = $utilisateur->getEmailAValider();
        $sujet = "Validation de l'adresse email";
        // Pour envoyer un email contenant du HTML
        $enTete = "MIME-Version: 1.0\r\n";
        $enTete .= "Content-type:text/html;charset=UTF-8\r\n";

        // Corps de l'email
        $loginURL = rawurlencode($utilisateur->getSiret());
        $nonceURL = rawurlencode($utilisateur->getNonce());
        $URLAbsolue = ConfigurationSite::getURLAbsolue();
        $lienValidationEmail = "$URLAbsolue?action=validerEmail&controleur=utilisateur&login=$loginURL&nonce=$nonceURL";
        $corpsEmailHTML = "<a href=\"$lienValidationEmail\">Validation</a>";

        // Temporairement avant d'envoyer un vrai mail
        echo "Simulation d'envoi d'un mail<br> Destinataire : $destinataire<br> Sujet : $sujet<br> Corps : <br>$corpsEmailHTML";

        // Quand vous aurez configué l'envoi de mail via PHP
        // mail($destinataire, $sujet, $corpsEmailHTML, $enTete);
    }

    public static function traiterEmailValidation($login, $nonce): bool
    {
        $utilisateur = (new EcoleRepository())->recupererParClePrimaire($login);
        if ($utilisateur && $utilisateur->getNonce() === $nonce) {
            $utilisateur->setMail($utilisateur->getEmailAValider());
            $utilisateur->setNonce("");
            (new EcoleRepository())->mettreAJour($utilisateur);
            return true;
        } else {
            return false;
        }
    }

    public static function aValideEmail(Ecole $utilisateur): bool
    {
        if ($utilisateur->getMail() != "") {
            return true;
        } else {
            return false;
        }

    }
}