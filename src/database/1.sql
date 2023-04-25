-- Mise à jour de la base de données
-- Date: 2023-04-12
-- Version avant mise à jour: 0
-- Version après mise à jour: 1
-- Description: Création de la base de données

CREATE TABLE burger_recette(
   id_recette INT AUTO_INCREMENT,
   nom_recette VARCHAR(50),
   photo_recette VARCHAR(50),
   date_archive_recette DATETIME,
   prix_recette REAL,
   PRIMARY KEY(id_recette)
) ENGINE=InnoDB;

CREATE TABLE burger_menu(
   id_menu INT AUTO_INCREMENT,
   PRIMARY KEY(id_menu)
) ENGINE=InnoDB;

CREATE TABLE burger_boisson(
   id_boisson INT AUTO_INCREMENT,
   PRIMARY KEY(id_boisson)
) ENGINE=InnoDB;

CREATE TABLE burger_unite(
   id_unite INT AUTO_INCREMENT,
   nom_unite VARCHAR(50) NOT NULL,
   diminutif_unite VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_unite)
) ENGINE=InnoDB;

CREATE TABLE burger_compte(
   id_compte INT AUTO_INCREMENT,
   identifiant_compte VARCHAR(50) NOT NULL,
   mot_de_passe_compte VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_compte)
) ENGINE=InnoDB;

CREATE TABLE burger_fournisseur(
   id_fournisseur INT AUTO_INCREMENT,
   nom_fournisseur VARCHAR(50),
   PRIMARY KEY(id_fournisseur)
) ENGINE=InnoDB;

CREATE TABLE burger_commande_fournisseur(
   id_commande INT AUTO_INCREMENT,
   date_commande DATETIME,
   date_archive_commande DATETIME,
   id_fournisseur_fk INT NOT NULL,
   PRIMARY KEY(id_commande),
   FOREIGN KEY(id_fournisseur_fk) REFERENCES burger_fournisseur(id_fournisseur)
) ENGINE=InnoDB;

CREATE TABLE burger_selection_multiple(
   id_slection_multiple INT AUTO_INCREMENT,
   nombre_sélection_multiple INT,
   id_recette_fk INT NOT NULL,
   PRIMARY KEY(id_slection_multiple),
   FOREIGN KEY(id_recette_fk) REFERENCES burger_recette(id_recette)
) ENGINE=InnoDB;

CREATE TABLE burger_ingredient(
   id_ingrendient INT AUTO_INCREMENT,
   nom_ingredient VARCHAR(50),
   quantite_stock_ingredient INT,
   photo_ingredient VARCHAR(50),
   photo_eclatee_ingredient VARCHAR(50),
   date_inventaire_ingredient DATETIME,
   stock_auto_ingredient BOOL,
   quantite_standard_ INT,
   quantite_minimum INT,
   id_fournisseur_fk INT NOT NULL,
   id_unite_fk INT NOT NULL,
   PRIMARY KEY(id_ingrendient),
   FOREIGN KEY(id_fournisseur_fk) REFERENCES burger_fournisseur(id_fournisseur),
   FOREIGN KEY(id_unite_fk) REFERENCES burger_unite(id_unite)
) ENGINE=InnoDB;

CREATE TABLE client(
   id_client INT AUTO_INCREMENT,
   prenom_client VARCHAR(50),
   ville_client VARCHAR(50),
   nombre_pizza_client VARCHAR(50),
   nom_client VARCHAR(50),
   telephone_client VARCHAR(50),
   adresse_client VARCHAR(50),
   id_compte INT NOT NULL,
   PRIMARY KEY(id_client),
   UNIQUE(id_compte),
   FOREIGN KEY(id_compte) REFERENCES burger_compte(id_compte)
) ENGINE=InnoDB;

CREATE TABLE burger_employe(
   id_employe INT AUTO_INCREMENT,
   matricule_employe VARCHAR(50),
   nom_employe VARCHAR(50),
   prenom_employe VARCHAR(50),
   id_compte INT NOT NULL,
   PRIMARY KEY(id_employe),
   UNIQUE(id_compte),
   FOREIGN KEY(id_compte) REFERENCES burger_compte(id_compte)
) ENGINE=InnoDB;

CREATE TABLE burger_gerant(
   id_employe INT,
   PRIMARY KEY(id_employe),
   FOREIGN KEY(id_employe) REFERENCES burger_employe(id_employe)
) ENGINE=InnoDB;

CREATE TABLE burger_livreur(
   id_employe INT,
   disponible_livreur BOOL,
   PRIMARY KEY(id_employe),
   FOREIGN KEY(id_employe) REFERENCES burger_employe(id_employe)
) ENGINE=InnoDB;

CREATE TABLE burger_cuisine(
   id_employe INT,
   PRIMARY KEY(id_employe),
   FOREIGN KEY(id_employe) REFERENCES burger_employe(id_employe)
) ENGINE=InnoDB;

CREATE TABLE burger_commande_client(
   id_commande INT AUTO_INCREMENT,
   taille_commande VARCHAR(50),
   prix_commande VARCHAR(50),
   detail_commande VARCHAR(50),
   date_commande DATETIME,
   id_client_fk INT NOT NULL,
   PRIMARY KEY(id_commande),
   FOREIGN KEY(id_client_fk) REFERENCES client(id_client)
) ENGINE=InnoDB;

CREATE TABLE burger_livraison(
   id_commande INT,
   heure_livraison VARCHAR(50),
   adresse VARCHAR(50),
   emballage VARCHAR(50),
   id_employe_fk INT,
   PRIMARY KEY(id_commande),
   FOREIGN KEY(id_commande) REFERENCES burger_commande_client(id_commande),
   FOREIGN KEY(id_employe_fk) REFERENCES burger_livreur(id_employe)
) ENGINE=InnoDB;

CREATE TABLE burger_retrait(
   id_commande INT,
   heure_retrait DATETIME,
   PRIMARY KEY(id_commande),
   FOREIGN KEY(id_commande) REFERENCES burger_commande_client(id_commande)
) ENGINE=InnoDB;

CREATE TABLE burger_recette_finale(
   id_recette_finale INT AUTO_INCREMENT,
   id_commande_fk INT,
   id_menu_fk INT,
   id_recette_fk INT NOT NULL,
   PRIMARY KEY(id_recette_finale),
   FOREIGN KEY(id_commande_fk) REFERENCES burger_commande_client(id_commande),
   FOREIGN KEY(id_menu_fk) REFERENCES burger_menu(id_menu),
   FOREIGN KEY(id_recette_fk) REFERENCES burger_recette(id_recette)
) ENGINE=InnoDB;

CREATE TABLE burger_ingredient_basique(
   id_recette INT,
   id_ingrendient INT,
   quantite SMALLINT,
   PRIMARY KEY(id_recette, id_ingrendient),
   FOREIGN KEY(id_recette) REFERENCES burger_recette(id_recette),
   FOREIGN KEY(id_ingrendient) REFERENCES burger_ingredient(id_ingrendient)
) ENGINE=InnoDB;

CREATE TABLE Asso_12(
   id_commande INT,
   id_menu INT,
   quantite SMALLINT NOT NULL,
   PRIMARY KEY(id_commande, id_menu),
   FOREIGN KEY(id_commande) REFERENCES burger_commande_client(id_commande),
   FOREIGN KEY(id_menu) REFERENCES burger_menu(id_menu)
) ENGINE=InnoDB;

CREATE TABLE Asso_13(
   id_menu INT,
   id_boisson INT,
   PRIMARY KEY(id_menu, id_boisson),
   FOREIGN KEY(id_menu) REFERENCES burger_menu(id_menu),
   FOREIGN KEY(id_boisson) REFERENCES burger_boisson(id_boisson)
) ENGINE=InnoDB;

CREATE TABLE Asso_18(
   id_commande INT,
   id_boisson INT,
   Quantité SMALLINT NOT NULL,
   PRIMARY KEY(id_commande, id_boisson),
   FOREIGN KEY(id_commande) REFERENCES burger_commande_client(id_commande),
   FOREIGN KEY(id_boisson) REFERENCES burger_boisson(id_boisson)
) ENGINE=InnoDB;

CREATE TABLE burger_ingredient_optionnel(
   id_recette INT,
   id_ingrendient INT,
   quantite SMALLINT,
   prix FLOAT NOT NULL,
   PRIMARY KEY(id_recette, id_ingrendient),
   FOREIGN KEY(id_recette) REFERENCES burger_recette(id_recette),
   FOREIGN KEY(id_ingrendient) REFERENCES burger_ingredient(id_ingrendient)
) ENGINE=InnoDB;

CREATE TABLE burger_ingredient_final(
   id_ingrendient INT,
   id_recette_finale_fk INT,
   quantite SMALLINT,
   PRIMARY KEY(id_ingrendient, id_recette_finale_fk),
   FOREIGN KEY(id_ingrendient) REFERENCES burger_ingredient(id_ingrendient),
   FOREIGN KEY(id_recette_finale_fk) REFERENCES burger_recette_finale(id_recette_finale)
) ENGINE=InnoDB;

CREATE TABLE burger_constituer(
   id_ingrendient INT,
   id_commande_fk INT,
   quantite_commandee SMALLINT,
   quantite_recue SMALLINT,
   PRIMARY KEY(id_ingrendient, id_commande_fk),
   FOREIGN KEY(id_ingrendient) REFERENCES burger_ingredient(id_ingrendient),
   FOREIGN KEY(id_commande_fk) REFERENCES burger_commande_fournisseur(id_commande)
) ENGINE=InnoDB;

CREATE TABLE burger_compter(
   id_ingrendient INT,
   id_slection_multiple INT,
   PRIMARY KEY(id_ingrendient, id_slection_multiple),
   FOREIGN KEY(id_ingrendient) REFERENCES burger_ingredient(id_ingrendient),
   FOREIGN KEY(id_slection_multiple) REFERENCES burger_selection_multiple(id_slection_multiple)
) ENGINE=InnoDB;
