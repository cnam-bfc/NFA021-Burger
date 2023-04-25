<?php
class InventaireController extends Controller
{
    public function renderViewInventaire()
    {
        $view = new View(BaseTemplate::EMPLOYE, 'InventaireView');
        $view->renderView();
    }

    /**
     * Méthode permettant de récupérer tous les ingrédients et de les préparer pour raffraichir le tableau des ingrédients
     *
     * @return void
     */
    public function refreshTableauInventaire()
    {
        // on récupère tous les ingrédients
        $ingredientDAO = new IngredientDAO();
        $ingredients = $ingredientDAO->selectAllForInventaire();

        // On vérifie qu'on a bien reçu des ingrédients
        if (!empty($ingredients)) {
            // on récupère les données pour la vue
            $result = array();
            foreach ($ingredients as $ingredient) {
                $result[] = array(
                    "id" => $ingredient["id_ingredient"],
                    "photo" => IMG . $ingredient["photo_ingredient"],
                    "nom" => $ingredient["nom_ingredient"],
                    "stock" => $ingredient["quantite_stock_ingredient"],
                    "unite" => $ingredient["diminutif_unite"]
                );
            }

            // tri des données pour la vue, on tri le tableau result en fonction du nom de l'ingrédient
            // note voir si on le fait sur le stock
            usort($result, function ($a, $b) {
                return $a['nom'] <=> $b['nom'];
            });
        }

        // envoi des données à la vue
        $view = new View(BaseTemplate::JSON);

        $view->json = $result;

        $view->renderView();
    }

    public function miseAJourInventaire()
    {
        // On vérifie et on récupère les données du formulaire sous forme de json
        $rawData = Form::getParam('data', Form::METHOD_POST, Form::TYPE_MIXED);
        $data = json_decode($rawData, true);

        // on traite les données et on actualise la base de données
        $ingredientDAO = new IngredientDAO();
        $result = array();
        foreach ($data as $ingredient) {
            $ingredientAUpdate = $ingredientDAO -> selectById($ingredient['id']);
            $ingredientAUpdate->setQuantiteStockIngredient($ingredient['stock']);
            $ingredientDAO->update($ingredientAUpdate);
        }

        $result = array(
            "success" => true
        );

        // envoi des données à la vue
        $view = new View(BaseTemplate::JSON);

        $view->json = $result;

        $view->renderView();
    }
}
