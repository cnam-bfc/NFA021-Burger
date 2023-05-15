<?php

/**
 * Objet CommandeClientRetrait
 */
class CommandeClientRetrait extends CommandeClient
{
    /**
     * Heure de retrait d'une commande d'un client (date et heure, format Y-m-d H:i:s)
     * 
     * @var string
     */
    private $heureRetrait;

    /**
     * Méthode permettant de récupérer l'heure de retrait d'une commande d'un client
     * 
     * @return string
     */
    public function getHeureRetrait()
    {
        return $this->heureRetrait;
    }

    /**
     * Méthode permettant de modifier l'heure de retrait d'une commande d'un client
     * 
     * @param string $heureRetrait (Date et heure au format Y-m-d H:i:s)
     * @return void
     */
    public function setHeureRetrait($heureRetrait)
    {
        $this->heureRetrait = $heureRetrait;
    }
}
