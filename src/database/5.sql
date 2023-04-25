-- Mise à jour de la base de données
-- Date: 2023-04-13
-- Version avant mise à jour: 4
-- Version après mise à jour: 5
-- Description: Renommage de la colonne "id_ingrendient" en "id_ingredient" dans la table "burger_ingredient"

ALTER TABLE burger_ingredient RENAME COLUMN id_ingrendient TO id_ingredient;
