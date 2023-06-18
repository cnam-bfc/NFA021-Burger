-- Mise à jour de la base de données
-- Date: 2023-06-16
-- Version avant mise à jour: 1
-- Version après mise à jour: 2
-- Description: Ajout du moyen de transport d'un livreur

-- Ajout de la table burger_moyen_transport
CREATE TABLE burger_moyen_transport(
   id_moyen_transport INT AUTO_INCREMENT,
   nom VARCHAR(50) NOT NULL,
   osrm_profile VARCHAR(20) NOT NULL,
   routexl_type VARCHAR(20) NOT NULL,
   date_archive DATETIME,
   PRIMARY KEY(id_moyen_transport)
) ENGINE=InnoDB;

-- Ajout de la colonne id_moyen_transport_fk dans la table burger_livreur
ALTER TABLE burger_livreur ADD id_moyen_transport_fk INT NOT NULL;
ALTER TABLE burger_livreur ADD CONSTRAINT id_moyen_transport_fk FOREIGN KEY(id_moyen_transport_fk) REFERENCES burger_moyen_transport(id_moyen_transport);
