<?php

/**
 * Objet Unite
 */
class Unite
{
    /**
     * Identifiant de l'unite
     * 
     * @var int
     */
    private $idUnite;

    /**
     * Nom de l'unite
     *
     * @var string
     */
    private $nomUnite;

    /**
     * Diminutif de l'unite
     * 
     * @var string
     */
    private $diminutifUnite;

    /**
     * Méthode permettant de récupérer l'identifiant de l'unite
     * 
     * @return int
     */
    public function getIdUnite()
    {
        return $this->idUnite;
    }

    /**
     * Méthode permettant de récupérer le nom de l'unite
     * 
     * @return string
     */
    public function getNomUnite()
    {
        return $this->nomUnite;
    }

    /**
     * Méthode permettant de récupérer le diminutif de l'unite
     * 
     * @return string
     */
    public function getDiminutifUnite()
    {
        return $this->diminutifUnite;
    }

    /**
     * Méthode permettant de modifier l'identifiant de l'unite
     * 
     * @param int $idUnite
     * @return void
     */
    public function setIdUnite($idUnite)
    {
        $this->idUnite = $idUnite;
    }

    /**
     * Méthode permettant de modifier le nom de l'unite
     * 
     * @param string $nomUnite
     * @return void
     */
    public function setNomUnite($nomUnite)
    {
        $this->nomUnite = $nomUnite;
    }

    /**
     * Méthode permettant de modifier le diminutif de l'unite
     * 
     * @param string $diminutifUnite
     * @return void
     */
    public function setDiminutifUnite($diminutifUnite)
    {
        $this->diminutifUnite = $diminutifUnite;
    }
}
