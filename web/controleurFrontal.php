<?php
require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';

use App\Sae\Controleur\ControleurEtudiant as ControleurEtudiant;

// initialisation en activant l'affichage de débogage
$chargeurDeClasse = new App\Sae\Lib\Psr4AutoloaderClass(false);
$chargeurDeClasse->register();
// enregistrement d'une association "espace de nom" → "dossier"
$chargeurDeClasse->addNamespace("App\Sae", __DIR__ . '/../src');


if (isset($_GET['controleur'])) {
    $controleur = $_GET['controleur'];
}else{
    $controleur = "etudiant";
}

$nomDeClasseControleur = "App\\Sae\\Controleur\\Controleur". ucfirst($controleur);
if(class_exists($nomDeClasseControleur)) {

    if (!isset($_GET['action'])) {
        $action = "afficherListe";
    } else {
        $action = $_GET['action'];
    }
    $methodes = get_class_methods($nomDeClasseControleur);
    if (in_array($action, $methodes)) {
        $nomDeClasseControleur::$action();
    } else {
        $nomDeClasseControleur::afficherErreur("Action non valide");
    }
}else{
    ControleurEtudiant::afficherErreur("Controleur non valide");
}

?>
