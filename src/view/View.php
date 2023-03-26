<?php

/**
 * Class View - Permet de générer une vue
 * 
 * On utilise un objet qui permet d'utiliser l'autoloader
 * 
 * @param string $template (nom du fichier de la vue)
 */
class View
{
    private $template;

    /**
     * Constructeur de la classe View
     *
     * @param string $template
     */
    public function __construct($template = null)
    {
        $this->template = $template;
    }

    /**
     * Méthode permettant de générer une vue
     *
     * @param array $data (tableau contenant les données à afficher)
     * @return void
     */
    public function renderView($data = array())
    {

        extract($data); // crée des variables à partir des clés d'un tableau
        ob_start();
        require_once VIEW . $this->template . ".php";
        $contentPage = ob_get_clean();

        require_once VIEW . "_gabarit.php";
    }

    /**
     * Méthode permettant de rediriger vers une autre page
     * 
     * @param string $route (route vers laquelle on veut rediriger)
     */
    public function redirect($route)
    {
        header("Location: $route");
        exit;
    }
}
