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

        if (!empty($_POST['idBdc'])) {
            $idBdc = $_POST['idBdc'];

            $dao = new CommandeFournisseurDAO();
            $bdc = $dao->selectById($idBdc);

            $bdc->setEtat(1);

            unset($_POST['idBdc']);
        }

        $view-> json = array("result"=>"success");
        $view->renderView();
    }
}
