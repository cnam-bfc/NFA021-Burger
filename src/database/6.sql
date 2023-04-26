-- Mise à jour de la base de données
-- Date: 2023-04-20
-- Version avant mise à jour: 5
-- Version après mise à jour: 6
-- Description: Renommage de la colonne "id_ingrendient" en "id_ingredient" dans les tables "burger_ingredient_basique", "burger_ingredient_optionnel", "burger_compter", "burger_ingredient_final" et "burger_constituer"

ALTER TABLE burger_ingredient_basique RENAME COLUMN id_ingrendient TO id_ingredient;

ALTER TABLE burger_ingredient_optionnel RENAME COLUMN id_ingrendient TO id_ingredient;

ALTER TABLE burger_compter RENAME COLUMN id_ingrendient TO id_ingredient;

ALTER TABLE burger_ingredient_final RENAME COLUMN id_ingrendient TO id_ingredient;

ALTER TABLE burger_constituer RENAME COLUMN id_ingrendient TO id_ingredient;
