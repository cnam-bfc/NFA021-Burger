<?php

class CollectLivraisonController extends Controller
{
    public function renderViewCollectORDelivery()
    {
        $view = new View(BaseTemplate::CLIENT, 'CollectORDeliveryView');


        $view->renderView();
    }

    public function validation()
    {
        $infosJSON = $_POST['infos'];
        $json_str = json_encode($infosJSON);
        $infos = json_decode($json_str, true);

        if ($infos === null) {
            error_log('Erreur de décodage JSON : ' . json_last_error_msg(), 0);
            $error = array('error' => 'Erreur de décodage JSON.');
            http_response_code(400); // code de réponse HTTP pour une erreur de requête
            echo json_encode($error);
            return;
        }



        $_SESSION['infosRecupCommande'] = $infos;



        $view = new View(BaseTemplate::JSON, null);
        $view->json = $infos;
        $view->renderView();
    }
}
