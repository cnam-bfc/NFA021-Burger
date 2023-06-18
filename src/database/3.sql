-- Mise à jour de la base de données
-- Date: 2023-06-16
-- Version avant mise à jour: 2
-- Version après mise à jour: 3
-- Description: Ajout de la date de récupération d'une livraison par un livreur

-- Ajout de la colonne heure_recuperation après la colonne heure_livraison dans la table burger_commande_client_livraison
ALTER TABLE burger_commande_client_livraison ADD heure_recuperation DATETIME AFTER heure_livraison;
