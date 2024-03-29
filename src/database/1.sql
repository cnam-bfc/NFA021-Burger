-- Mise à jour de la base de données
-- Date: 2023-05-15
-- Version avant mise à jour: 0
-- Version après mise à jour: 1
-- Description: Création de la base de données

CREATE TABLE burger_recette(
   id_recette INT AUTO_INCREMENT,
   nom VARCHAR(50) NOT NULL,
   description TEXT NOT NULL,
   prix DECIMAL(19,4) NOT NULL,
   date_archive DATETIME,
   PRIMARY KEY(id_recette)
) ENGINE=InnoDB;

CREATE TABLE burger_unite(
   id_unite INT AUTO_INCREMENT,
   nom VARCHAR(30) NOT NULL,
   diminutif VARCHAR(10) NOT NULL,
   date_archive DATETIME,
   PRIMARY KEY(id_unite)
) ENGINE=InnoDB;

CREATE TABLE burger_compte(
   id_compte INT AUTO_INCREMENT,
   login VARCHAR(30) NOT NULL,
   email VARCHAR(254) NOT NULL,
   password VARCHAR(255) NOT NULL,
   date_archive DATETIME,
   PRIMARY KEY(id_compte),
   UNIQUE(login),
   UNIQUE(email)
) ENGINE=InnoDB;

CREATE TABLE burger_fournisseur(
   id_fournisseur INT AUTO_INCREMENT,
   nom VARCHAR(50) NOT NULL,
   date_archive DATETIME,
   PRIMARY KEY(id_fournisseur)
) ENGINE=InnoDB;

CREATE TABLE burger_commande_fournisseur(
   id_commande_fournisseur INT AUTO_INCREMENT,
   creation_automatique BOOLEAN NOT NULL,
   date_creation DATETIME NOT NULL,
   date_commande DATETIME,
   date_archive DATETIME,
   id_fournisseur_fk INT NOT NULL,
   PRIMARY KEY(id_commande_fournisseur),
   FOREIGN KEY(id_fournisseur_fk) REFERENCES burger_fournisseur(id_fournisseur)
) ENGINE=InnoDB;

CREATE TABLE burger_recette_selection_multiple(
   id_recette_selection_multiple INT AUTO_INCREMENT,
   ordre TINYINT NOT NULL,
   quantite INT NOT NULL,
   id_recette_fk INT NOT NULL,
   PRIMARY KEY(id_recette_selection_multiple),
   FOREIGN KEY(id_recette_fk) REFERENCES burger_recette(id_recette)
) ENGINE=InnoDB;

CREATE TABLE burger_emballage(
   id_emballage INT AUTO_INCREMENT,
   nom VARCHAR(50) NOT NULL,
   date_archive DATETIME,
   PRIMARY KEY(id_emballage)
) ENGINE=InnoDB;

CREATE TABLE burger_ingredient(
   id_ingredient INT AUTO_INCREMENT,
   nom VARCHAR(50) NOT NULL,
   afficher_vue_eclatee BOOLEAN NOT NULL,
   quantite_stock INT NOT NULL,
   stock_auto BOOLEAN NOT NULL,
   stock_auto_quantite_standard INT,
   stock_auto_quantite_minimum INT,
   prix_fournisseur DECIMAL(19,4),
   date_inventaire DATETIME NOT NULL,
   date_archive DATETIME,
   id_unite_fk INT NOT NULL,
   id_fournisseur_fk INT NOT NULL,
   PRIMARY KEY(id_ingredient),
   FOREIGN KEY(id_unite_fk) REFERENCES burger_unite(id_unite),
   FOREIGN KEY(id_fournisseur_fk) REFERENCES burger_fournisseur(id_fournisseur)
) ENGINE=InnoDB;

CREATE TABLE burger_client(
   id_compte INT,
   nom VARCHAR(50) NOT NULL,
   prenom VARCHAR(50) NOT NULL,
   telephone VARCHAR(30),
   adresse_osm_type VARCHAR(50),
   adresse_osm_id INT,
   adresse_code_postal VARCHAR(5),
   adresse_ville VARCHAR(50),
   adresse_rue VARCHAR(50),
   adresse_numero VARCHAR(10),
   PRIMARY KEY(id_compte),
   FOREIGN KEY(id_compte) REFERENCES burger_compte(id_compte)
) ENGINE=InnoDB;

CREATE TABLE burger_employe(
   id_compte INT,
   matricule VARCHAR(32),
   nom VARCHAR(50) NOT NULL,
   prenom VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_compte),
   FOREIGN KEY(id_compte) REFERENCES burger_compte(id_compte)
) ENGINE=InnoDB;

CREATE TABLE burger_gerant(
   id_compte INT,
   PRIMARY KEY(id_compte),
   FOREIGN KEY(id_compte) REFERENCES burger_employe(id_compte)
) ENGINE=InnoDB;

CREATE TABLE burger_livreur(
   id_compte INT,
   PRIMARY KEY(id_compte),
   FOREIGN KEY(id_compte) REFERENCES burger_employe(id_compte)
) ENGINE=InnoDB;

CREATE TABLE burger_cuisinier(
   id_compte INT,
   PRIMARY KEY(id_compte),
   FOREIGN KEY(id_compte) REFERENCES burger_employe(id_compte)
) ENGINE=InnoDB;

CREATE TABLE burger_commande_client(
   id_commande_client INT AUTO_INCREMENT,
   prix DECIMAL(19,4) NOT NULL,
   date_commande DATETIME NOT NULL,
   date_pret DATETIME,
   date_archive DATETIME,
   id_emballage_fk INT NOT NULL,
   id_compte_fk INT NOT NULL,
   PRIMARY KEY(id_commande_client),
   FOREIGN KEY(id_emballage_fk) REFERENCES burger_emballage(id_emballage),
   FOREIGN KEY(id_compte_fk) REFERENCES burger_client(id_compte)
) ENGINE=InnoDB;

CREATE TABLE burger_commande_client_livraison(
   id_commande_client INT,
   heure_livraison DATETIME NOT NULL,
   adresse_osm_type VARCHAR(50) NOT NULL,
   adresse_osm_id INT NOT NULL,
   adresse_code_postal CHAR(5) NOT NULL,
   adresse_ville VARCHAR(50) NOT NULL,
   adresse_rue VARCHAR(50) NOT NULL,
   adresse_numero VARCHAR(10),
   id_compte_fk INT,
   PRIMARY KEY(id_commande_client),
   FOREIGN KEY(id_commande_client) REFERENCES burger_commande_client(id_commande_client),
   FOREIGN KEY(id_compte_fk) REFERENCES burger_livreur(id_compte)
) ENGINE=InnoDB;

CREATE TABLE burger_commande_client_retrait(
   id_commande_client INT,
   heure_retrait DATETIME NOT NULL,
   PRIMARY KEY(id_commande_client),
   FOREIGN KEY(id_commande_client) REFERENCES burger_commande_client(id_commande_client)
) ENGINE=InnoDB;

CREATE TABLE burger_recette_finale(
   id_recette_finale INT AUTO_INCREMENT,
   quantite INT NOT NULL,
   id_commande_client_fk INT,
   id_recette_fk INT NOT NULL,
   PRIMARY KEY(id_recette_finale),
   FOREIGN KEY(id_commande_client_fk) REFERENCES burger_commande_client(id_commande_client),
   FOREIGN KEY(id_recette_fk) REFERENCES burger_recette(id_recette)
) ENGINE=InnoDB;

CREATE TABLE burger_recette_ingredient_basique(
   id_recette_ingredient_basique INT AUTO_INCREMENT,
   ordre TINYINT NOT NULL,
   quantite INT NOT NULL,
   id_ingredient_fk INT NOT NULL,
   id_recette_fk INT NOT NULL,
   PRIMARY KEY(id_recette_ingredient_basique),
   FOREIGN KEY(id_ingredient_fk) REFERENCES burger_ingredient(id_ingredient),
   FOREIGN KEY(id_recette_fk) REFERENCES burger_recette(id_recette)
) ENGINE=InnoDB;

CREATE TABLE burger_recette_ingredient_optionnel(
   id_recette_ingredient_optionnel INT AUTO_INCREMENT,
   ordre TINYINT NOT NULL,
   quantite INT NOT NULL,
   prix DECIMAL(19,4) NOT NULL,
   id_ingredient_fk INT NOT NULL,
   id_recette_fk INT NOT NULL,
   PRIMARY KEY(id_recette_ingredient_optionnel),
   FOREIGN KEY(id_ingredient_fk) REFERENCES burger_ingredient(id_ingredient),
   FOREIGN KEY(id_recette_fk) REFERENCES burger_recette(id_recette)
) ENGINE=InnoDB;

CREATE TABLE burger_recette_finale_ingredient(
   id_recette_finale_ingredient INT AUTO_INCREMENT,
   ordre TINYINT NOT NULL,
   quantite INT NOT NULL,
   id_recette_finale_fk INT NOT NULL,
   id_ingredient_fk INT NOT NULL,
   PRIMARY KEY(id_recette_finale_ingredient),
   FOREIGN KEY(id_recette_finale_fk) REFERENCES burger_recette_finale(id_recette_finale),
   FOREIGN KEY(id_ingredient_fk) REFERENCES burger_ingredient(id_ingredient)
) ENGINE=InnoDB;

CREATE TABLE burger_commande_fournisseur_ingredient(
   id_ingredient_fk INT,
   id_commande_fournisseur_fk INT,
   quantite_commandee INT NOT NULL,
   quantite_recue INT,
   PRIMARY KEY(id_ingredient_fk, id_commande_fournisseur_fk),
   FOREIGN KEY(id_ingredient_fk) REFERENCES burger_ingredient(id_ingredient),
   FOREIGN KEY(id_commande_fournisseur_fk) REFERENCES burger_commande_fournisseur(id_commande_fournisseur)
) ENGINE=InnoDB;

CREATE TABLE burger_ingredient_recette_selection_multiple(
   id_ingredient_fk INT,
   id_recette_selection_multiple_fk INT,
   quantite INT NOT NULL,
   PRIMARY KEY(id_ingredient_fk, id_recette_selection_multiple_fk),
   FOREIGN KEY(id_ingredient_fk) REFERENCES burger_ingredient(id_ingredient),
   FOREIGN KEY(id_recette_selection_multiple_fk) REFERENCES burger_recette_selection_multiple(id_recette_selection_multiple)
) ENGINE=InnoDB;
