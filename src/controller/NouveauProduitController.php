<?php
class NouveauProduitController extends Controller
{
    public function renderView()
    {
        $view = new View(BaseTemplate::EMPLOYE, 'NouveauProduitView');

        $fournisseurDAO = new FournisseurDAO();
        $view->fournisseur = $fournisseurDAO->selectAll();

        $uniteDAO = new UniteDAO();
        $view->unite = $uniteDAO->selectAll();

        $ingr = new Ingredient();


        //Si le tableau $_GET existe, il s'agit d'une modification d'ingrédient, il faut récupérer l'objet concerné. 
        if (isset($_GET['nomProduit'])) {
            $dao = new IngredientDAO();

            $nom = $_GET['nomProduit'];

            $ingr = $dao->selectByName($nom);

            unset($_GET['nomProduit']);
        }

        $view->ingredient = $ingr;


        //Si le tableau $_POST existe alors le formulaire de création/modification a bien été envoyé.
        if (!empty($_POST)) {

            if (!empty($_POST['id']))
                $id = $_POST["id"];
        
            if (!empty($_POST['nom']))
                $nom = $_POST["nom"];
        
            if (!empty($_POST['fournisseur']))
                $fournisseur = $_POST["fournisseur"];
            else
                $fournisseur = "";
        
            if (isset($_POST['stockAuto']))
                $wizard = 1;
            else
                $wizard = 0;
        
            if (!empty($_POST['qteStock']))
                $qteStock = $_POST["qteStock"];
            else
                $qteStock = 0;
        
            if (!empty($_POST['qteMin']))
                $min = $_POST["qteMin"];
            else
                $min = 0;
        
            if (!empty($_POST['qteStandard']))
                $standard = $_POST["qteStandard"];
            else
                $standard = 0;
        
            if (!empty($_POST['unite']))
                $unite = $_POST["unite"];
            else
                $unite = "";
        
            $fournisseurDAO = new FournisseurDAO();
        
            $uniteDAO = new UniteDAO();
        
            $ingr = new Ingredient();
            $ingr->setNomIngredient($nom);
            $ingr->setQuantiteStockIngredient($qteStock);
            $ingr->setDateInventaireIngredient(date('Y-m-d H:i:s',time()));
            $ingr->setStockAutoIngredient($wizard);
            $ingr->setQuantiteMinimum($min);
            $ingr->setQuantiteStandard($standard);
            $ingr->setIdFournisseurFK($fournisseurDAO->selectByName($fournisseur)->getIdFournisseur());
            $ingr->setIdUniteFK($uniteDAO->selectByName($unite)->getIdUnite());
        
            $dao = new IngredientDAO();
        
            if (isset($id)) {
                // Si $id existe, alors il s'agit d'une mise à jour d'ingrédient.
                $ingr->setIdIngredient($id);
                $dao->update($ingr);
            } else {
                // Si $id n'existe pas, il s'agit d'une création d'ingrédient.
                $dao->create($ingr);
            }
        
            unset($_POST);
        }


        $view->renderView();
    }
}