<?php
class ListeBDCController extends Controller
{
    public function renderView()
    {
        $dao = new BdcDAO();
        $bdc = $dao->selectAll();

        $tableau = array();

        foreach ($bdc as $donnees) {

            $tableau[] = array(
                $donnees->getIdBdc(),
                $donnees->getDateCreationBdc(),
                $donnees->getDateArchiveBdc(),
                $donnees->getIdFournisseurFK()
            );
        }
        $view = new View(BaseTemplate::JSON);

        $view->json = $tableau;

        $view = new View(BaseTemplate::EMPLOYE, 'ListeBDCView');
        $view->renderView();
    }
}
