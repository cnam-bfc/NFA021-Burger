<?php
/**
 * Objet IngredientCommandeFournisseur
 * /!\ Attention, le nom à l'heure actuelle dans la bdd est burger_constitue
 */
class IngredientCommandeFournisseur
{
    /**
     * Identifiant de l'ingrédient
     *
     * @var int
     */
    private $idIngredient;

    /**
     * Identifiant de la commande
     * 
     * @var string
     */
    private $idCommande;

    /**
     * Quantité de l'ingrédient commandée
     *
     * @var int
     */
    private $quantiteCommandee;

    /**
     * Quantité de l'ingrédient reçue
     *
     * @var int
     */
    private $quantiteRecue;

    /**
     * Méthode permettant de récupérer l'identifiant de l'ingrédient
     *
     * @return int
     */
    public function getIdIngredient()
    {
        return $this->idIngredient;
    }

    /**
     * Méthode permettant de récupérer l'identifiant de la commande
     *
     * @return string
     */
    public function getIdCommande()
    {
        return $this->idCommande;
    }

    /**
     * Méthode permettant de récupérer la quantité de l'ingrédient commandée
     *
     * @return int
     */
    public function getQuantiteCommandee()
    {
        return $this->quantiteCommandee;
    }

    /**
     * Méthode permettant de récupérer la quantité de l'ingrédient reçue
     *
     * @return int
     */
    public function getQuantiteRecue()
    {
        return $this->quantiteRecue;
    }

    /**
     * Méthode permettant de définir l'identifiant de l'ingrédient
     *
     * @param int $idIngredient Identifiant de l'ingrédient
     * @return void
     */
    public function setIdIngredient($idIngredient)
    {
        $this->idIngredient = $idIngredient;
    }

    /**
     * Méthode permettant de définir l'identifiant de la commande
     *
     * @param string $idCommande Identifiant de la commande
     * @return void
     */
    public function setIdCommande($idCommande)
    {
        $this->idCommande = $idCommande;
    }

    /**
     * Méthode permettant de définir la quantité de l'ingrédient commandée
     *
     * @param int $quantiteCommandee Quantité de l'ingrédient commandée
     * @return void
     */
    public function setQuantiteCommandee($quantiteCommandee)
    {
        $this->quantiteCommandee = $quantiteCommandee;
    }

    /**
     * Méthode permettant de définir la quantité de l'ingrédient reçue
     *
     * @param int $quantiteRecue Quantité de l'ingrédient reçue
     * @return void
     */
    public function setQuantiteRecue($quantiteRecue)
    {
        $this->quantiteRecue = $quantiteRecue;
    }
}
