<?php
class ListeBDCController extends Controller
{
    public function renderView()
    {
        $view = new View(BaseTemplate::EMPLOYE, 'ListeBDCView');
        $view->renderView();
    }

    //Méthode qui permet de récupérer les données en bdd
    public function donneesBdc()
    {
        $bdcDao = new CommandeFournisseurDAO();
        $bdc = $bdcDao->selectAll();

        $fournisseurDao = new FournisseurDAO();
        $ingredientBdcDao = new CommandeFournisseurIngredientDAO();
        $ingredientDao = new IngredientDAO();

        $tableauBdc = array();

        foreach ($bdc as $donnees) {

            $listeIngredients = $ingredientBdcDao->selectAllByIdCommandeFournisseur($donnees->getId());
            $montant = 0;

            foreach ($listeIngredients as $ingr) {

                $montant += ($ingredientDao->selectById($ingr->getIdIngredient()))->getPrixFournisseur() * $ingr->getQuantiteCommandee();
            }

            $tableauBdc[] = array(
                "id" => $donnees->getId(),
                "creation" => $donnees->getDateCreation(),
                "validation" => $donnees->getDateCommande(),
                "archive" => $donnees->getDateArchive(),
                "fournisseur" => ($fournisseurDao->selectById($donnees->getIdFournisseur()))->getNom(),
                "montant" => $montant
            );
        }

        $view = new View(BaseTemplate::JSON);

        $view->json = $tableauBdc;
        $view->renderView();
    }

    //Méthode qui permet de valider un bdc
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

        $view->json = array("id" => $idBdc);
        $view->renderView();
    }
}
