# SKI700 - Site E-Commerce

Site e-commerce en cours de développement en HTML, CSS, PHP et MySQL, appliquant des standards de développement.

------------------------------------------------------------------------

## Fonctionnalités principales

-   **Catalogue dynamique** : Navigation par articles de ski avec affichage des détails.
-   **Panneaux Utilisateurs** : Inscription, connexion sécurisée, déconnexion et historique des commandes.
-   **Panier interactif** : Ajout, suppression et validation d'achats.
-   **Gestion des stocks avancée** : Système de réservation temporaire pour éviter les conflits de stocks lors des commandes simultanées.

------------------------------------------------------------------------

## Architecture et Organisation du Code

Le projet adopte une séparation stricte des responsabilités : **Vues (`index.php`, `panier.php`, `historique.php`...)** : Interface utilisateur en HTML/CSS (`styles/style1.css`), sans code logique mélangé. **Contrôleurs / Actions (`acheter.php`, `retirer.php`, `connecter.php`...)** : Scripts de traitement pur sans affichage, gérant les redirections (`header`) de manière sécurisée (absence de caractères parasites avant les en-têtes). **Gestion d'État** : Utilisation intensive des sessions (`$_SESSION`) pour le suivi de la connexion utilisateur et du contenu du panier.

------------------------------------------------------------------------

## Sécurité Web

Le projet intègre des protections robustes contre les vulnérabilités courantes : **Injections SQL** : Utilisation systématique de l'interface **PDO** avec des requêtes préparées (`prepare` + `execute`). \* **Failles XSS (Cross-Site Scripting)** : Assainissement rigoureux des entrées utilisateur via `htmlspecialchars()`. **Failles CSRF (Cross-Site Request Forgery)** : Mise en place d'un système de jetons (tokens) générés côté serveur et vérifiés avant toute modification de la base de données.

------------------------------------------------------------------------

## Logique Métier Avancée (Gestion de stock concurrentielle)

Pour pallier les problèmes de concurrence sur les stocks (type billetterie / SNCF) : **Table Tampon (Réservations)** : Lors de l'ajout au panier ou de l'achat, les articles sont virtuellement bloqués et déduits dans une table dédiée pendant une durée limitée. **Nettoyage Automatisé** : Un script supprime dynamiquement les réservations expirées (`DELETE FROM reservations WHERE expiration < NOW()`) à chaque interaction utilisateur, garantissant des stocks en temps réel sans nécessiter de tâches cron complexes.

------------------------------------------------------------------------

## Évolutions Futures & Améliorations Prévues

Le projet n'est pas fini. Les prochaines étapes d'optimisation intègrent : **Intégration d'AJAX,** **Améliorations en JavaScript (Client-side)**.

------------------------------------------------------------------------

## Structure du Projet

SKI700

├── 📁 articles/ \# Vues ou données relatives aux articles

├── 📁 contact/ \# Page et logique de contact

├── 📁 images/ \# Ressources graphiques du site

├── 📁 styles/ \# Feuilles de style CSS (style1.css)

├── 📄 acheter.php \# Traitement de l'achat / validation panier

├── 📄 ski700.sql \# Script de création de la base de données

├── 📄 bd.php \# Connexion à la base de données (PDO)

├── 📄 commande.php \# Traitement des commandes

├── 📄 connecter.php \# Traitement du formulaire de connexion

├── 📄 connexion.php \# Vue du formulaire de connexion

├── 📄 deconnexion.php \# Destruction de session

├── 📄 enregistrement.php \# Inscription des utilisateurs

├── 📄 historique.php \# Historique des achats clients

├── 📄 index.php \# Page d'accueil / catalogue

├── 📄 nouveau.php \# Ajout / gestion de nouveaux éléments

├── 📄 panier.php \# Gestion et affichage du panier

└── 📄 retirer.php \# Retrait d'un article du panier

------------------------------------------------------------------------

## Installation et Lancement

### Prérequis

-   Un serveur local MySQL actif (via **MAMP**, **XAMPP** ou **WAMP**).
-   PHP installé sur votre machine.

### Étape 1 : Importer la base de données

1.  Lancez votre serveur MySQL (via MAMP/XAMPP).
2.  Rendez-vous sur phpMyAdmin (ou un client SQL équivalent).
3.  Créez une nouvelle base de données (ex: `ski700`).
4.  Importez-y le fichier **`article.sql`** situé à la racine du projet.

### Étape 2 : Configurer la connexion (`bd.php`)

Ouvrez le fichier `bd.php` et vérifiez que les paramètres de connexion PDO correspondent à votre environnement local (par exemple : utilisateur `root`, mot de passe `root` pour MAMP, ou `""` pour XAMPP/Windows).

### Étape 3 : Lancer le site
Pour lancer le site avec MAMP, placez le dossier du projet dans le répertoire htdocs, puis accédez à l'adresse http://localhost/nom-du-dossier/index.php depuis votre navigateur.
