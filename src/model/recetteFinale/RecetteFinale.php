<?php

/**
 * Objet RecetteFinale
 */
class RecetteFinale
{
    /**
     * Identifiant de la recette finale
     * 
     * @var int
     */
    private $id;

    /**
     * Quantité de la recette finale
     * 
     * @var int
     */
    private $quantite;

    /**
     * Identifiant de la commande client de la recette finale
     * 
     * @var int
     */
    private $idCommandeClient;

    /**
     * Identifiant de la recette de la recette finale
     * 
     * @var int
     */
    private $idRecette;

    /**
     * Méthode permettant de récupérer l'identifiant de la recette finale
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Méthode permettant de récupérer la quantité de la recette finale
     * 
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Méthode permettant de récupérer l'identifiant de la commande client de la recette finale
     * 
     * @return int
     */
    public function getIdCommandeClient()
    {
        return $this->idCommandeClient;
    }

    /**
     * Méthode permettant de récupérer l'identifiant de la recette de la recette finale
     * 
     * @return int
     */
    public function getIdRecette()
    {
        return $this->idRecette;
    }

    /**
     * Méthode permettant de modifier l'identifiant de la recette finale
     * 
     * @param int $id
     * @return void
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }

    /**
     * Méthode permettant de modifier la quantité de la recette finale
     * 
     * @param int $quantite
     * @return void
     */
    public function setQuantite($quantite)
    {
        $this->quantite = (int) $quantite;
    }

    /**
     * Méthode permettant de modifier l'identifiant de la commande client de la recette finale
     * 
     * @param int $idCommandeClient
     * @return void
     */
    public function setIdCommandeClient($idCommandeClient)
    {
        $this->idCommandeClient = (int) $idCommandeClient;
    }

    /**
     * Méthode permettant de modifier l'identifiant de la recette de la recette finale
     * 
     * @param int $idRecette
     * @return void
     */
    public function setIdRecette($idRecette)
    {
        $this->idRecette = (int) $idRecette;
    }
}
