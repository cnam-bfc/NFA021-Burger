-- Mise à jour de la base de données
-- Date: 2023-04-13
-- Version avant mise à jour: 1
-- Version après mise à jour: 2
-- Description: Renommage de la colonne "quantite_standard_" en "quantite_standard" dans la table "burger_ingredient"

ALTER TABLE burger_ingredient RENAME COLUMN quantite_standard_ TO quantite_standard;
