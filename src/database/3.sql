-- Mise à jour de la base de données
-- Date: 2023-04-13
-- Version avant mise à jour: 2
-- Version après mise à jour: 3
-- Description: Ajout de la colonne "description_recette" dans la table "burger_recette" après la colonne "nom_recette"

ALTER TABLE burger_recette ADD COLUMN description_recette TEXT AFTER nom_recette;
