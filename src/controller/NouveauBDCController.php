<?php
class NouveauBDCController extends Controller
{
    public function renderView()
    {
        $view = new View(BaseTemplate::EMPLOYE, 'NouveauBDCView');
        $fournisseurDao = new FournisseurDAO(); 

        $view->fournisseurs = $fournisseurDao->selectAll();

        if (!empty($_POST['produit'])) {
            echo $_POST['produit'];
        }

        $view->renderView();
    }

    public function listeProduits()
    {
        $dao = new IngredientDAO();
        $ingredient = $dao->selectAll();

        $tableau = array();

        foreach ($ingredient as $donnees) {

            $tableau[] = array(
                "id" => $donnees->getId(),
                "nom" => $donnees->getNom(),
                "prix" => $donnees->getPrixFournisseur(),
                "idFournisseur" => $donnees->getIdFournisseur()
            );
        }
        $view = new View(BaseTemplate::JSON);
        $view->json = $tableau;
        $view->renderView();
    }
}
