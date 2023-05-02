<?php
class NouveauBDCController extends Controller
{
    public function renderView()
    {
        $view = new View(BaseTemplate::EMPLOYE, 'NouveauBDCView');
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
    
}
