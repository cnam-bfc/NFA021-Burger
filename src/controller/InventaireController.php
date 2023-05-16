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
        $ingredients = $ingredientDAO->selectAllNonArchive();

        // on récupère toutes les unités
        $uniteDAO = new UniteDAO();
        $unites = $uniteDAO->selectAll();
        $uniteFormat = array();
        foreach ($unites as $unite) {
            $uniteFormat[$unite->getId()] = $unite->getDiminutif();
        }
        

        // On vérifie qu'on a bien reçu des ingrédients
        if (!empty($ingredients)) {
            // on récupère les données pour la vue
            $result = array();
            foreach ($ingredients as $ingredient) {
                $result[] = array(
                    "id" => $ingredient->getId(),
                    "photo" => IMG . 'ingredients' . DIRECTORY_SEPARATOR . $ingredient->getId() . DIRECTORY_SEPARATOR . 'presentation.img',
                    "nom" => $ingredient->getNom(),
                    "stock" => $ingredient->getQuantiteStock(),
                    "unite" => $uniteFormat[$ingredient->getIdUnite()]
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
            $ingredientAUpdate->setQuantiteStock($ingredient['stock']);
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
