<?php

/**
 * Class View - Permet de générer une vue
 * 
 * On utilise un objet qui permet d'utiliser l'autoloader
 */
class View
{
    /**
     * Tableau contenant les données à afficher dans la vue
     *
     * @var array
     */
    private $data = array();
    private $baseTemplate;
    private $template;

    /**
     * Constructeur de la classe
     * 
     * @param string $baseTemplate (nom du gabarit de base)
     * @param string $template (nom du gabarit à afficher)
     */
    public function __construct($baseTemplate, $template)
    {
        $this->setBaseTemplate($baseTemplate);
        $this->setTemplate($template);
    }

    /**
     * Méthode permettant de définir une variable à afficher dans la vue
     * 
     * @param string $key (nom de la variable)
     * @param mixed $value (valeur de la variable)
     */
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * Méthode permettant de récupérer une variable à afficher dans la vue
     * 
     * @param string $key (nom de la variable)
     * @return mixed
     */
    public function __get($name)
    {
        return $this->data[$name];
    }

    /**
     * Méthode permettant de récupérer le gabarit de base
     * 
     * @return string
     */
    public function getBaseTemplate()
    {
        return $this->baseTemplate;
    }

    /**
     * Méthode permettant de définir le gabarit de base
     * 
     * @param string $baseTemplate (nom du gabarit de base)
     */
    public function setBaseTemplate($baseTemplate)
    {
        $this->baseTemplate = $baseTemplate;
    }

    /**
     * Méthode permettant de récupérer le gabarit à afficher
     * 
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Méthode permettant de définir le gabarit à afficher
     * 
     * @param string $template (nom du gabarit à afficher)
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    /**
     * Méthode permettant de générer la vue
     */
    public function renderView()
    {
        // On extrait les données du tableau $data pour pouvoir les utiliser dans la vue
        extract($this->data);

        // On génère le contenu de la vue à partir du template
        if ($this->template !== null) {
            ob_start();
            require_once VIEW . $this->template . '.php';
            $templateContent = ob_get_clean();
        }

        // On génère le template de base avec le contenu de la vue
        require_once VIEW . 'template' . DIRECTORY_SEPARATOR . $this->baseTemplate . 'BaseTemplate.php';
    }
}
