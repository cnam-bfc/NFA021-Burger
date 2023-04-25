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
}
