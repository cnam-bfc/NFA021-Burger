<?php
class ListeBDCController extends Controller
{
    public function renderView()
    {
        $view = new View(BaseTemplate::EMPLOYE, 'ListeBDCView');
        $view->renderView();
        //$this->donneesBdc();
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
                "etat" => $donnees->getEtat(),
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

            $jsonString = $_POST['data'];
            $jsonData = json_decode($jsonString);
    
            $idBdc = $jsonData[0];

            $dao = new CommandeFournisseurDAO();
            $bdc = $dao->selectById($idBdc);

            $bdc->setEtat(1);
            $dao->update($bdc);

            unset($_POST['data']);
        }

        $view->json = array("result" => "success");
        $view->renderView();
    }
}
