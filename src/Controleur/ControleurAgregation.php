<?php
namespace App\Sae\Controleur;

use App\Sae\Lib\ConnexionUtilisateur;
use App\Sae\Modele\Repository\AgregationRepository;

class ControleurAgregation extends ControleurGenerique
{
    /**
     * @return void affiche la liste des agregations
     */
    public static function afficherListe(): void
    {
        if (!ConnexionUtilisateur::estAdministrateur()) {
            self::afficherErreur("Vous n'avez pas les droits administrateurs");
            return;
        }
        $agregations = (new AgregationRepository())->recuperer();
        ControleurGenerique::afficherVue("vueGenerale.php", ["titre" => "Liste des agregations", "cheminCorpsVue" => "agregation/liste.php", "agregations" => $agregations]);

    }

    /**
     * @return void affiche la compostion d'une agrégation
     */
    public static function afficherDetail(): void{
        if (!ConnexionUtilisateur::estAdministrateur()) {
            self::afficherErreur("Vous n'avez pas les droits administrateurs");
            return;
        }
        if($_REQUEST['id']){
            $agregation = (new AgregationRepository())->recupererParClePrimaire($_REQUEST['id']);
            if($agregation){
                /*$listeRessources = (new AgregationRepository())->listeRessourcesAgregees($agregation->getIdAgregation(), $agregation->getEtudiant()->getEtudid());
                $listeAgregations = (new AgregationRepository())->listeAgregationsAgregees($agregation->getIdAgregation());
                */ControleurGenerique::afficherVue("vueGenerale.php", ["titre" => "page Agrégation", "cheminCorpsVue" => "agregation/detail.php", "agregation" => $agregation/*, "listeRessources" => $listeRessources, "listeAgregations" => $listeAgregations*/]);
            }else{
                self::afficherErreur("L'id n'est pas celle d'une agrégation");
            }
        }else{
            self::afficherErreur("L'id de l'étudiant n'a pas été transmis");
        }
    }

    /**
     * @param string $erreur message d'erreur à afficher
     * @return void afficher la page d'erreur
     */
    public static function afficherErreur(string $erreur): void
    {
        ControleurGenerique::afficherVue("vueGenerale.php", ["titre" => "Erreur", "cheminCorpsVue" => "agregation/erreur.php", "erreur" => $erreur]);
    }
}