<?php

class ProfilController extends Controller
{
    public function renderView()
    {
        $userSession = UserSession::getUserSession();
        if ($userSession->isLogged()) {
            if ($userSession->isClient()) {
                $this->renderViewClient();
                return;
            } else if ($userSession->isEmploye()) {
                $this->renderViewEmploye();
                return;
            }
        }

        Router::redirect('connexion');
        exit();
    }

    public function renderViewClient()
    {
        $view = new View(BaseTemplate::CLIENT, 'ProfilClientView');

        $view->renderView();
    }

    public function renderViewEmploye()
    {
        $view = new View(BaseTemplate::EMPLOYE, 'ProfilEmployeView');

        $view->renderView();
    }
}
