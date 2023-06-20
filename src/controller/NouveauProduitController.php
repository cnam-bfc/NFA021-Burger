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
        if (isset($_GET['idIngredient'])) {
            $dao = new IngredientDAO();

            $id = $_GET['idIngredient'];

            $ingr = $dao->selectById($id);

            unset($_GET['idIngredient']);

            $view->ingredient = $ingr;
        }


        //Si le tableau $_POST existe alors le formulaire de création/modification a bien été envoyé.
        if (!empty($_POST)) {

            //On récupère les données de chaque clé
            if (!empty($_POST['id']))
                $id = $_POST["id"];

            if (!empty($_POST['nom']))
                $nom = $_POST["nom"];


            if (!empty($_POST['fournisseur']))
                $fournisseur = $_POST['fournisseur'];

            if (!empty($_POST['prix']))
                $prix = $_POST['prix'];

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

            if ($_POST['unite'])
                $unite = $_POST['unite'];

            //On récupère l'image de la recette
            if (isset($id)) {
                $ingredientImage = Form::getFile('icone', false);
            } else {
                $ingredientImage = Form::getFile('icone', true);
            }
            $ingredientImageEclatee = Form::getFile('eclate', false);

            //On crée un objet un ingrédient avec les données récupérées
            $ingr = new Ingredient();
            $ingr->setNom($nom);
            $ingr->setPrixFournisseur($prix);
            $ingr->setQuantiteStock($qteStock);
            $ingr->setDateDernierInventaire(date('Y-m-d H:i:s', time()));
            $ingr->setStockAuto($wizard);
            $ingr->setQuantiteMinimaleStockAuto($min);
            $ingr->setQuantiteStandardStockAuto($standard);
            $ingr->setIdFournisseur($fournisseur);
            $ingr->setIdUnite($unite);

            $dao = new IngredientDAO();

            //S'il y a une image éclatée, on l'ajoute à l'ingrédient
            if ($ingredientImageEclatee !== null)
                $ingr->setAfficherVueEclatee(true);

            if (isset($id) and $dao->selectById($id)->isAfficherVueEclatee())
                $ingr->setAfficherVueEclatee(true);

            if (isset($id) and $ingredientImageEclatee === null and !($dao->selectById($id)->isAfficherVueEclatee()))
                $ingr->setAfficherVueEclatee(false);

            if (!isset($id) and $ingredientImageEclatee === null)
                $ingr->setAfficherVueEclatee(false);

            if (isset($id)) {
                // Si $id existe, alors il s'agit d'une mise à jour d'ingrédient.
                $ingr->setId($id);
                $dao->update($ingr);
            } else {
                // Si $id n'existe pas, il s'agit d'une création d'ingrédient.
                $dao->create($ingr);
                $id = $ingr->getId();
            }

            if ($ingredientImage !== null) {
                //On déplace l'image dans le dossier des images des ingrédients
                $ingredientFolder = DATA_INGREDIENTS . $id . DIRECTORY_SEPARATOR;
                if (!file_exists($ingredientFolder)) {
                    mkdir($ingredientFolder, 0777, true);
                }
                $ingredientImagePresentation = $ingredientFolder . 'presentation.img';
                move_uploaded_file($ingredientImage['tmp_name'], $ingredientImagePresentation);
            }

            if ($ingredientImageEclatee !== null) {
                // Déplacement de l'image dans le dossier des images des ingrédients
                $ingredientFolder = DATA_INGREDIENTS . $id . DIRECTORY_SEPARATOR;
                if (!file_exists($ingredientFolder)) {
                    mkdir($ingredientFolder, 0777, true);
                }
                $ingredientEclatee = $ingredientFolder . 'eclate.img';
                move_uploaded_file($ingredientImageEclatee['tmp_name'], $ingredientEclatee);
            }
            unset($_POST);
        }

        $view->renderView();
    }
}
