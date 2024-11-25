<?php
require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';

use App\Sae\Controleur\ControleurEtudiant as ControleurEtudiant;
use App\Sae\Lib\ChoixControleur;
use App\Sae\Lib\ConnexionUtilisateur;

// initialisation en activant l'affichage de débogage
$chargeurDeClasse = new App\Sae\Lib\Psr4AutoloaderClass(false);
$chargeurDeClasse->register();
// enregistrement d'une association "espace de nom" → "dossier"
$chargeurDeClasse->addNamespace("App\Sae", __DIR__ . '/../src');

$action = 'afficherFormulaireConnexion';
$nomDeClasseControleur = '';

// Vérifier si 'controleur' est défini et construire le nom de la classe du contrôleur
if (isset($_REQUEST['controleur'])) {
    $controleur = ucfirst($_REQUEST['controleur']);
    $nomDeClasseControleur = "App\Sae\Controleur\Controleur" . $controleur;
} else {
    $nomDeClasseControleur = "App\Sae\Controleur\ControleurEtudiant";
}

// Vérifier si la classe du contrôleur existe, sinon afficher une erreur
if (!class_exists($nomDeClasseControleur)) {
    $nomDeClasseControleur = 'App\Sae\Controleur\ControleurEtudiant';
    $action = 'afficherErreur';
} else {
    // Si l'action est définie, la vérifier et l'utiliser
    if (isset($_REQUEST['action'])) {
        $action = $_REQUEST['action'];
        // Si l'action n'est pas une méthode de la classe, afficher une erreur
        if (!method_exists($nomDeClasseControleur, $action)) {
            $action = 'afficherErreur';
        }

    }
}

if (ConnexionUtilisateur::estConnecte()) {
    if (ConnexionUtilisateur::estAdministrateur()) {
        $action = 'afficherListe';
    } else if (ConnexionUtilisateur::estEtudiant()) {
        $action = 'afficherEtudiantPage';
    }
}

// Appeler l'action sur le contrôleur déterminé
$nomDeClasseControleur::$action();

