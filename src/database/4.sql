-- Mise à jour de la base de données
-- Date: 2023-04-13
-- Version avant mise à jour: 3
-- Version après mise à jour: 4
-- Description: Ajout de la colonne "date_archive_ingredient" dans la table "burger_ingredient" après la colonne "quantite_minimum"

ALTER TABLE burger_ingredient ADD COLUMN date_archive_ingredient DATETIME AFTER quantite_minimum;
