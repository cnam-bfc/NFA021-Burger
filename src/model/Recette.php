<?php

class Recette
{
    private $idRecette;
    private $nomRecette;
    private $photoRecette;
    private $dateArchiveRecette;
    private $prixRecette;

    // Getters
    function getIdRecette()
    {
        return $this->idRecette;
    }

    function getNomRecette()
    {
        return $this->nomRecette;
    }

    function getPhotoRecette()
    {
        return $this->photoRecette;
    }

    function getDateArchiveRecette()
    {
        return $this->dateArchiveRecette;
    }

    function getPrixRecette()
    {
        return $this->prixRecette;
    }

    // Setters
    function setIdRecette($idRecette)
    {
        $this->idRecette = $idRecette;
    }

    function setNomRecette($nomRecette)
    {
        $this->nomRecette = $nomRecette;
    }

    function setPhotoRecette($photoRecette)
    {
        $this->photoRecette = $photoRecette;
    }

    function setDateArchiveRecette($dateArchiveRecette)
    {
        $this->dateArchiveRecette = $dateArchiveRecette;
    }

    function setPrixRecette($prixRecette)
    {
        $this->prixRecette = $prixRecette;
    }
}
