<?php
class AuthentificationController extends Controller
{
    public function renderViewConnexion()
    {
        $view = new View(BaseTemplate::EMPTY, 'ConnexionView');

        // Définition des variables utilisées dans la vue

        $view->renderView();
    }

    public function connexion()
    {
    }

    public function renderViewMotDePasseOublie()
    {
        $view = new View(BaseTemplate::EMPTY, 'MotDePasseOublieView');

        // Définition des variables utilisées dans la vue

        $view->renderView();
    }

    public function envoiMailMotDePasseOublie()
    {
    }

    public function deconnexion()
    {
    }

    public function renderViewInscription()
    {
        $view = new View(BaseTemplate::EMPTY, 'InscriptionView');

        // Définition des variables utilisées dans la vue

        $view->renderView();
    }

    public function inscription()
    {
    }
}
