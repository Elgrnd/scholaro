<?php

namespace App\Sae\Controleur;

use App\Sae\Lib\ConnexionUtilisateur;
use App\Sae\Modele\DataObject\Agregation;
use App\Sae\Modele\DataObject\Etudiant;
use App\Sae\Modele\Repository\AgregationRepository;
use App\Sae\Modele\Repository\EtudiantRepository;
use App\Sae\Modele\Repository\RessourceRepository;

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
    public static function afficherDetail(): void
    {
        if (!ConnexionUtilisateur::estAdministrateur()) {
            self::afficherErreur("Vous n'avez pas les droits administrateurs");
            return;
        }
        if ($_REQUEST['id']) {
            $agregation = (new AgregationRepository())->recupererParClePrimaire($_REQUEST['id']);
            if ($agregation) {
                /*$listeRessources = (new AgregationRepository())->listeRessourcesAgregees($agregation->getIdAgregation(), $agregation->getEtudiant()->getEtudid());
                $listeAgregations = (new AgregationRepository())->listeAgregationsAgregees($agregation->getIdAgregation());
                */
                ControleurGenerique::afficherVue("vueGenerale.php", ["titre" => "page Agrégation", "cheminCorpsVue" => "agregation/detail.php", "agregation" => $agregation/*, "listeRessources" => $listeRessources, "listeAgregations" => $listeAgregations*/]);
            } else {
                self::afficherErreur("L'id n'est pas celle d'une agrégation");
            }
        } else {
            self::afficherErreur("L'id de l'étudiant n'a pas été transmis");
        }
    }

    public static function afficherFormulaire(): void
    {
        if (!ConnexionUtilisateur::estAdministrateur()) {
            self::afficherErreur("Vous n'avez pas les droits administrateurs");
        } else {
            $agregations = (new AgregationRepository())->recuperer();
            $ressources = (new RessourceRepository())->recuperer();
            ControleurGenerique::afficherVue("vueGenerale.php", ['titre' => "creer agrégation", "cheminCorpsVue" => "agregation/agregationFormulaire.php", "agregations" => $agregations, "ressources" => $ressources]);
        }
    }

    public static function construireDepuisFormulaire()
    {
        if (ConnexionUtilisateur::estAdministrateur()) {
            if ((isset($_REQUEST['nomAgregation'])) && isset($_REQUEST['count'])) {
                for ($i = 0; $i < $_REQUEST['count']; $i++) {
                    if ($_REQUEST['coeff' . $i] > 0) {
                        $tabNom[] = $_REQUEST['idNom' . $i];
                        $tabCoeff[] = $_REQUEST['coeff' . $i];
                    }
                }
                if (!empty($tabNom) && !empty($tabCoeff)) {
                    $agregation = new Agregation(null, $_REQUEST['nomAgregation']);
                    $idAgregation = (new AgregationRepository())->ajouter($agregation);
                    $a = (new EtudiantRepository())->recuperer();
                    var_dump($tabNom);
                    for ($i = 0; $i < count($tabNom); $i++) {

                        if (($tabNom[$i][0])=== 'R') {
                            (new EtudiantRepository())->enregistrerRessourceAgregee($tabNom[$i], $idAgregation, $tabCoeff[$i]);
                        } else {
                            (new EtudiantRepository())->enregistrerAgregationAgregee($idAgregation, $tabNom[$i], $tabCoeff[$i]);
                        }
                    }
                    foreach ($a as $etudiant) {
                        $moyenne = $etudiant->calculerMoyenne($tabNom, $tabCoeff);
                        if ($moyenne != -1) {
                            (new AgregationRepository())->ajouterEtudiant($idAgregation, $etudiant->getEtudid(), $moyenne);
                        }
                    }
                    $agregations = (new AgregationRepository())->recuperer();
                    ControleurGenerique::afficherVue("vueGenerale.php", ["titre" => "Liste des agregations", "cheminCorpsVue" => "agregation/liste.php", "agregations" => $agregations]);
                } else {
                    self::afficherErreur("Aucune ressource ou agrégation ont été enregistré");
                }

            } else {
                self::afficherErreur("Vous avez oublié le nom de l'agrégation à créer et/ou de sélectionner des ressources");
            }
        } else {
            self::afficherErreur("Vous n'avez pas les droits administrateurs");
        }
    }

    /**
     * @param string $erreur message d'erreur à afficher
     * @return void afficher la page d'erreur
     */
    public
    static function afficherErreur(string $erreur): void
    {
        ControleurGenerique::afficherVue("vueGenerale.php", ["titre" => "Erreur", "cheminCorpsVue" => "agregation/erreur.php", "erreur" => $erreur]);
    }
}