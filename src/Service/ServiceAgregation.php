<?php

namespace App\Sae\Service;

use App\Sae\Exception\ArgNullException;
use App\Sae\Exception\DroitException;
use App\Sae\Lib\ConnexionUtilisateur;
use App\Sae\Lib\MessageFlash;
use App\Sae\Modele\Repository\AgregationRepository;
use App\Sae\Modele\Repository\RessourceRepository;
use mysql_xdevapi\Exception;

class ServiceAgregation
{
    /**
     * @param $login
     * @return array retourne la liste des agrégations demandées sinon renvoie une Exception si il y a un problème
     * @throws DroitException
     */
    public function recupererListe($login): array
    {
        if (!ConnexionUtilisateur::estAdministrateur() && !ConnexionUtilisateur::estEcolePartenaire($login)) {
            throw new DroitException("Vous n'avez pas les droits");
        }
        if (ConnexionUtilisateur::estEcolePartenaire($login)) {
            $agregations = (new AgregationRepository())->recupererParUtilisateur($login);
        } else {
            $agregations = (new AgregationRepository())->recupererParUtilisateur("prof");
        }
        foreach ($agregations as $agregation) {
            $listeRessources = (new AgregationRepository())->listeRessourcesAgregees($agregation->getIdAgregation());
            $listeAgregation = (new AgregationRepository())->listeAgregationsAgregees($agregation->getIdAgregation());
            if (empty($listeAgregation) && empty($listeRessources)) {
                (new AgregationRepository())->supprimer($agregation->getIdAgregation());
            }
        }
        return $agregations;
    }

    /**
     * @param $idAgregation
     * @return array retourne l'agregation et les listes en rapport et ainsi que sa moyenne
     * @throws ArgNullException
     * @throws DroitException
     */
    public function detail($idAgregation): array
    {
        if (!ConnexionUtilisateur::estAdministrateur() && !ConnexionUtilisateur::estEcolePartenaire(ConnexionUtilisateur::getLoginUtilisateurConnecte())) {
            throw new DroitException("Vous n'avez pas les droits");
        }
        if (!$idAgregation) {
            throw new ArgNullException("L'id n'a pas été transmise");
        }
        $repository = new AgregationRepository();
        $ressourceRepo = new RessourceRepository();

        // Récupération de l'agrégation principale
        $agregation = $repository->recupererParClePrimaire($idAgregation);
        if (!$agregation) {
            throw new ArgNullException("L'id n'est pas celui d'une agrégation");
        }
        if ($agregation->getSiretCreateur() != ConnexionUtilisateur::getLoginUtilisateurConnecte()) {
            throw new DroitException("Vous n'avez pas créée cette agrégation");
        }
        // Récupération des listes associées
        $listeRessources = $repository->listeRessourcesAgregees($idAgregation);
        $listeAgregations = $repository->listeAgregationsAgregees($idAgregation);

        // Calcul de la moyenne
        $moyenne = 0;
        $coefTotal = 0;

        foreach ($listeRessources as $ressource) {
            $moyenne += $ressourceRepo->moyenne($ressource[0]) * $ressource[1];
            $coefTotal += $ressource[1];
        }

        foreach ($listeAgregations as $agreg) {
            $moyenne += $repository->moyenne($agreg[0]) * $agreg[1];
            $coefTotal += $agreg[1];
        }

        if ($coefTotal > 0) {
            $moyenne /= $coefTotal;
        }
        $moyenne = round($moyenne, 2);

        return [
            'agregation' => $agregation,
            'listeRessources' => $listeRessources,
            'listeAgregations' => $listeAgregations,
            'moyenne' => $moyenne
        ];
    }

    public function supprimer($idAgregation): void
    {
        if (!$idAgregation) {
            throw new ArgNullException("L'id n'est pas passé en paramètre.");
        }
        $repository = new AgregationRepository();
        $login = ConnexionUtilisateur::getLoginUtilisateurConnecte();
        $agregation = $repository->recupererParClePrimaire($idAgregation);
        if (!$agregation) {
            throw new ArgNullException("L'agrégation spécifiée n'existe pas.");
        }
        if (!ConnexionUtilisateur::estAdministrateur() &&
            (($agregation->getLoginCreateur() && $agregation->getLoginCreateur() !== $login) ||
                ($agregation->getSiretCreateur() && $agregation->getSiretCreateur() !== $login))) {
            throw new DroitException("Vous n'avez pas les droits pour supprimer cette agrégation.");
        }
        $repository->supprimer($idAgregation);
    }
}