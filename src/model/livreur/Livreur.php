<?php

/**
 * Objet Livreur
 */
class Livreur extends Employe
{
    /**
     * Identifiant du moyen de transport du livreur
     * 
     * @var int
     */
    private $idMoyenTransport;

    /**
     * Méthode permettant de récupérer l'identifiant du moyen de transport du livreur
     * 
     * @return int
     */
    public function getIdMoyenTransport()
    {
        return $this->idMoyenTransport;
    }

    /**
     * Méthode permettant de modifier l'identifiant du moyen de transport du livreur
     *
     * @param int $idMoyenTransport Identifiant du moyen de transport du livreur
     * @return void
     */
    public function setIdMoyenTransport($idMoyenTransport)
    {
        $this->idMoyenTransport = $idMoyenTransport;
    }
}
