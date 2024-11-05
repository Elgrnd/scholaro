<?php

namespace App\Sae\Controleur;

use App\Sae\Lib\ChoixControleur;

class ControleurGenerique
{

    /**
     * @param string $cheminVue Le chemin de la vue à utiliser
     * @param array $parametres des paramètres supplémentaire pour des informations spécifiques aux pages
     * @return void fonctions à appeler pour afficher une vue
     */
    protected static function afficherVue(string $cheminVue, array $parametres = []): void
    {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ . "/../vue/$cheminVue"; // Charge la vue
    }

    public static function afficherFormulaireConnexion(): void
    {
        self::afficherVue("vueGenerale.php", ["titre" => "Connexion", "cheminCorpsVue" => "formulaireConnexion.php"]);
    }
}