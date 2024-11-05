# sae3a-base

<h2>Installation du site</h2>

<h3>1. Connexion au conteneur</h3>

Connectez-vous à votre conteneur en utilisant Docker ou un autre outil d'administration de conteneurs.

    docker exec -it serveurWebIUT /bin/bash

<h3>2. Clonage du dépôt Git</h3>

Dans le conteneur, naviguez vers le répertoire où vous souhaitez installer le site web, puis clonez le dépôt Git contenant le code source du site.

    cd /var/www/html  # Exemple de répertoire web par défaut
    git clone https://gitlabinfo.iutmontp.univ-montp2.fr/sae3a/projets/lyfoungn-desertg-tordeuxm-nedjary-laurentg/sae3a-base.git

<h3>3. Configuration des droits d'accès</h3>

Assurez-vous que le serveur web a les droits nécessaires pour accéder aux fichiers du site. Réglez les permissions pour le répertoire cloné.

    chown -R www-data:www-data siteWebIUT  # Remplacez `www-data` par l'utilisateur web si différent
    chmod -R 755 siteWebIUT

<h3>4. Installation des dépendances</h3>

    cd siteWebIUT
    composer install

<h3>5. Configuration de l'environnement</h3>

Créez un fichier de configuration d’environnement pour stocker les variables sensibles (comme les identifiants de base de données).

    cp .env.example .env

Modifiez .env pour inclure les informations spécifiques à votre environnement :

    nano .env
    Enregistrez et quittez.

<h3>6. Démarrage du serveur</h3>

Lancez ou redémarrez le serveur web pour prendre en compte les nouvelles configurations.

    service apache2 restart  # Exemple pour Apache
    # ou
    service nginx restart    # Exemple pour Nginx

<h3>7. Vérification de l'installation</h3>

Accédez à l'URL de votre serveur pour vérifier que le site web est correctement installé. Par exemple :

    http://localhost  # Si vous êtes en local dans le conteneur

Note : Assurez-vous que le conteneur serveurWebIUT dispose des ports réseau ouverts pour autoriser l'accès externe si nécessaire.

<h2>URL du site</h2>
/home/ann2/lyfoungn/public_html

<h2> Login / mot de passe </h2>
Professeur : pallejax / ok

Etudiant : 99 / 22000151

<h2> Fonctionnalités </h2>
1 - Importation Etudiant en xlsx

2 - Agregation de Note

3 - Agregation d'agregation

4 - Connection d'un professeur

5 - Connection d'un étudiant