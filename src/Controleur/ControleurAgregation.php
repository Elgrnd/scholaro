<?php
namespace App\Sae\Controleur;

use App\Sae\Lib\ConnexionUtilisateur;
use App\Sae\Modele\Repository\AgregationRepository;

class ControleurAgregation extends ControleurGenerique
{
    public static function afficherListe(): void
    {
        if (!ConnexionUtilisateur::estAdministrateur()) {
            self::afficherErreur("Vous n'avez pas les droits administrateurs");
        }
        $agregations = (new AgregationRepository())->recuperer();
        ControleurGenerique::afficherVue("vueGenerale.php", ["titre" => "Liste des agregations", "cheminCorpsVue" => "agregation/liste.php", "agregations" => $agregations]);

    }
}