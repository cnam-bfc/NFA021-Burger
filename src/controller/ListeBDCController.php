<?php
class ListeBDCController extends Controller
{
    public function renderView()
    {
        $view = new View(BaseTemplate::EMPLOYE, 'ListeBDCView');
        $view->renderView();
    }

    public function donneesBdc()
    {
        $bdcDao = new CommandeFournisseurDAO();
        $bdc = $bdcDao->selectAll();

        $fournisseurDao = new FournisseurDAO();

        $tableau = array();

        foreach ($bdc as $donnees) {

            $tableau[] = array(
                "id" => $donnees->getId(),
                "creation" => $donnees->getDateCreation(),
                "validation" => $donnees->getDateCommande(),
                "archive" => $donnees->getDateArchive(),
                "fournisseur" => ($fournisseurDao->selectById($donnees->getIdFournisseur()))->getNom()
            );
        }
        $view = new View(BaseTemplate::JSON);

        $view->json = $tableau;
        $view->renderView();
    }

    public function validerBdc()
    {
        $view = new View(BaseTemplate::JSON);


        if (isset($_POST['data'])) {

            $rawData = Form::getParam('data', Form::METHOD_POST, Form::TYPE_MIXED);
            $data = json_decode($rawData, true);
    
            $idBdc = $data['id'];

            $dao = new CommandeFournisseurDAO();
            $bdc = $dao->selectById($idBdc);

            $bdc->setDateCommande(date("Y-m-d H:i:s"));
            $dao->update($bdc);

            unset($_POST['data']);
        }

        $view->json = array ("id" => $idBdc);
        $view->renderView();
    }
}
