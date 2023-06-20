-- Mise à jour de la base de données
-- Date: 2023-06-16
-- Version avant mise à jour: 3
-- Version après mise à jour: 4
-- Description: Modification du type des colonnes adresse_osm_id dans les tables burger_commande_client_livraison & burger_client

-- Modification du type de la colonne adresse_osm_id dans la table burger_commande_client_livraison
ALTER TABLE burger_commande_client_livraison MODIFY adresse_osm_id BIGINT NOT NULL;

-- Modification du type de la colonne adresse_osm_id dans la table burger_client
ALTER TABLE burger_client MODIFY adresse_osm_id BIGINT;
