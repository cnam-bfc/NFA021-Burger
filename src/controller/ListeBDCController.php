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

        $bdcDao = new BdcDAO();
        $bdc = $bdcDao->selectAll();

        $fournisseurDao = new FournisseurDAO();

        $tableau = array();

        foreach ($bdc as $donnees) {

            $tableau[] = array(
                "id" => $donnees->getIdBdc(),
                "etat" => $donnees->getEtatBdc(),
                "fournisseur" => ($fournisseurDao->selectById($donnees->getIdFournisseurFK()))->getNomFournisseur()
            );
        }
        $view = new View(BaseTemplate::JSON);

        $view->json = $tableau;
        $view->renderView();
    }

    public function validerBdc()
    {
        $view = new View(BaseTemplate::EMPLOYE, 'ListeBDCView');

        if (!empty($_POST['idBdc'])) {
            $idBdc = $_POST['idBdc'];

            $dao = new BdcDAO();
            $bdc = $dao->selectById($idBdc);

            $bdc->setEtatBdc(1);

            unset($_POST['idBdc']);
        }

        $view->renderView();
    }
}
