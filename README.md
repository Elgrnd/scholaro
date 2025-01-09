# Projet SAE3A - Assistance à la Poursuite d'Études

## Installation du site web

1. **Clonage du dépôt**
    - Clonez le dépôt Git dans le conteneur `serveurWebIUT` :
      ```bash
      git clone https://gitlabinfo.iutmontp.univ-montp2.fr/sae3a/projets/lyfoungn-desertg-tordeuxm-nedjary-laurentg/sae3a-base.git
      cd <NOM_DU_DEPOT>
      ```  

2. **Configuration des droits**
    - Assurez-vous que les droits sur les fichiers et dossiers sont correctement définis :
      ```bash
      chmod -R 755 .
      ```  

3. **Configuration du serveur**
    - Placez les fichiers du projet dans le répertoire racine de votre serveur web (généralement `/var/www/html/`).
    - Vérifiez que les modules nécessaires sont activés (PHP, MySQL).

---

## Déploiement sur webinfo

Le site est déployé à l'URL suivante :  
[Scolaro](https://webinfo.iutmontp.univ-montp2.fr/~lyfoungn/sae3a-base/web/controleurFrontal.php)

---

## Informations sur la base de données

- **Nom de la base de données** : `SAE3A_Q2B`
- **Utilisateurs et mots de passe** :
    - Responsable :
      - Login : `laurentg`
      - Mot de passe : `jsp`
  - Enseignant :
      - Login : `Utiliser vos login LDAP`
      - Mot de passe : `Utiliser votre MDP LDAP`
  - Étudiant :
      - Login : `lyfoungn`
      - Mot de passe : `080342376AJ`
  - Ecole Partenaire :
      - Login : `12342567`
      - Mot de passe : `azer`

---

## Principales fonctionnalités développées

1. **Importation de données**
    - Importation des informations des étudiants et des notes via des fichiers CSV.

2. **Trier des étudiants**
    - Permet un tri croissant ou décroissant des étudiants liéer au notes d'une agrégation.

3. **Agrégation de notes**
    - Création d'agrégation qui calcul automatiquement les moyennes.

4. **Generation de la feuille gérants la poursuite d'étude**
    - Le responsable de poursuite d'étude peut géner la feuille de poursuite d'étude.

5. **Gestion des utilisateurs**
    - Connexion sécurisée avec différents rôles (enseignant, étudiant, entreprise).

---
