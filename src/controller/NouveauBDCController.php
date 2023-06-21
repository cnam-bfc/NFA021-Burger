<?php
class NouveauBDCController extends Controller
{
    public function renderView()
    {
        $view = new View(BaseTemplate::EMPLOYE, 'NouveauBDCView');
        $fournisseurDao = new FournisseurDAO();

        $view->fournisseurs = $fournisseurDao->selectAllNonArchive();

        //Si le tableau $_POST existe alors il s'agit d'un bdc qui existait déjà en bdd, on récupère les données
        if (!empty($_GET)) {

            $daoBdc = new CommandeFournisseurDAO();
            $view->bdc = $daoBdc->selectById($_GET['idBdc']);

            $daoIngredientsBdc = new CommandeFournisseurIngredientDAO();
            $view->listeIngredientsBdc = $daoIngredientsBdc->selectAllByIdCommandeFournisseur($_GET['idBdc']);

            $daoIngredients = new IngredientDAO();
            $view->listeIngredients = $daoIngredients->selectAllNonArchive();

            $daoUnite = new UniteDAO();
            $view->listeUnites = $daoUnite->selectAll();
        }

        //Si le tableau $_POST existe alors le formulaire a bien été envoyé et le bdc a été validé.
        if (!empty($_POST)) {

            $commandeFournisseurIngredientDAO = new CommandeFournisseurIngredientDAO();
            $commandeFournisseurDAO = new CommandeFournisseurDAO();
            $ingredientNouveau = new CommandeFournisseurIngredient();
            $bdc = null;

            if (!empty($_POST['fournisseur']))
                $fournisseur = $_POST["fournisseur"];

            //Il s'agit d'un bdc qui existait déjà
            if (!empty($_POST['idBdc'])) {
                $idBdc = $_POST["idBdc"];

                //MàJ du bdc
                $bdc = $commandeFournisseurDAO->selectById($idBdc);
                $bdc->setDateCommande(date('Y-m-d H:i:s'));
                $bdc->setIdFournisseur($fournisseur);

                $commandeFournisseurDAO->update($bdc);

                //On supprime tous les ingrédients de la commande avant modification du bdc
                $ingredientsAncien = $commandeFournisseurIngredientDAO->selectAllByIdCommandeFournisseur($bdc->getId());
                foreach ($ingredientsAncien as $ingredient) {
                    $commandeFournisseurIngredientDAO->delete($ingredient);
                }

                //On récupère les nouveaux ingrédients du bdc et on les créé en bdd
                $clefs = array_keys($_POST);
                for ($i = 2; $i < count($clefs);) {
                    $i++;

                    if (!empty($_POST[$clefs[$i]]))
                        $quantiteIngredient = $_POST[$clefs[$i]];
                    $i++;

                    if (!empty($_POST[$clefs[$i]]))
                        $idIngredient = $_POST[$clefs[$i]];
                    $i++;

                    $ingredientNouveau->setIdIngredient($idIngredient);
                    $ingredientNouveau->setQuantiteCommandee($quantiteIngredient);
                    $ingredientNouveau->setIdCommandeFournisseur($bdc->getId());

                    $commandeFournisseurIngredientDAO->create($ingredientNouveau);
                }

                //Il s'agit d'un nouveau bdc manuel
            } else {
                //Creation du bdc
                $bdc = new CommandeFournisseur();
                $bdc->setCreationAutomatique(0);
                $bdc->setDateCreation(date('Y-m-d H:i:s'));
                $bdc->setDateCommande(date('Y-m-d H:i:s'));
                $bdc->setIdFournisseur($fournisseur);

                $commandeFournisseurDAO = new CommandeFournisseurDAO();
                $commandeFournisseurDAO->create($bdc);

                //Creation des ingrédients du bdc
                $clefs = array_keys($_POST);
                for ($i = 2; $i < count($clefs);) {

                    if (!empty($_POST[$clefs[$i]]))
                        $quantiteIngredient = $_POST[$clefs[$i]];
                    $i++;

                    if (!empty($_POST[$clefs[$i]]))
                        $idIngredient = $_POST[$clefs[$i]];
                    $i+=2;

                    $ingredientNouveau->setIdIngredient($idIngredient);
                    $ingredientNouveau->setQuantiteCommandee($quantiteIngredient);
                    $ingredientNouveau->setIdCommandeFournisseur($bdc->getId());

                    $commandeFournisseurIngredientDAO->create($ingredientNouveau);
                }
            }

            unset($_POST);
        }

        $view->renderView();
    }

    public function listeProduits()
    {
        $dao = new IngredientDAO();
        $ingredient = $dao->selectAllNonArchive();
        $daoUnite = new UniteDAO();

        $tableau = array();

        foreach ($ingredient as $donnees) {

            $tableau[] = array(
                "id" => $donnees->getId(),
                "nom" => $donnees->getNom(),
                "unite" => $daoUnite->selectById($donnees->getIdUnite())->getNom(),
                "prix" => $donnees->getPrixFournisseur(),
                "idFournisseur" => $donnees->getIdFournisseur()
            );
        }
        $view = new View(BaseTemplate::JSON);
        $view->json = $tableau;
        $view->renderView();
    }
}
