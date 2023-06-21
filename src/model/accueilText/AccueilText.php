<?php

/**
 * Objet AccueilText
 */
class AccueilText
{

    /**
     * Identifiant du texte
     * 
     * @var int
     */
    private $id;

    /**
     * Titre du texte
     * 
     * @var string
     */
    private $title;

    /**
     * Texte
     * 
     * @var string
     */
    private $text;

    /**
     * Méthode permettant de récupérer l'identifiant du texte
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Méthode permettant de récupérer le titre du texte
     * 
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Méthode permettant de récupérer le texte
     * 
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Méthode permettant de modifier l'identifiant du texte
     * 
     * @param int $id Identifiant du texte
     * 
     * @return void
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Méthode permettant de modifier le titre du texte
     * 
     * @param string $title Titre du texte
     * 
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Méthode permettant de modifier le texte
     * 
     * @param string $text Texte
     * 
     * @return void
     */
    public function setText($text)
    {
        $this->text = $text;
    }
}
