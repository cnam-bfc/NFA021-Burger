<?php
class StockController extends Controller
{
    public function renderViewStock()
    {
        $view = new View(BaseTemplate::EMPLOYE, 'StockView');
        $view->renderView();
    }

    /**
     * Fonction permettant de récupérer tous les bons de commandes
     *
     * @return void
     */
    public function getBonsCommandesAJAX()
    {
        // On récupère tous les bons de commandes
        $bdcDAO = new CommandeFournisseurDAO();
        $bonsCommande = $bdcDAO->selectAllNonArchive();

        // on récupère les données pour la vue
        $result = array();

        // On vérifie qu'on a bien reçu des ingrédients
        if (!empty($bonsCommande)) {
            foreach ($bonsCommande as $bonCommande) {
                $result[] = array(
                    "id_commande" => $bonCommande -> getId(),
                    "date_commande" => $bonCommande -> getDateCommande(),
                    "id_fournisseur_fk" => $bonCommande -> getIdFournisseur()
                );
            }

            // tri des données pour la vue, on tri le tableau result en fonction du nom de l'ingrédient
            // note voir si on le fait sur le stock
            usort($result, function ($a, $b) {
                return $a['date_commande'] <=> $b['date_commande'];
            });
        }

        // envoi des données à la vue
        $view = new View(BaseTemplate::JSON);

        $view->json = $result;

        $view->renderView();
    }
    
    /**
     * Fonction qui permet de récupérer les fournisseurs
     *
     * @return void
     */
    public function getFournisseursAJAX()
    {
        // On récupère tous les fournisseurs
        $fournisseurDAO = new FournisseurDAO();
        $fournisseurs = $fournisseurDAO->selectAll();

        // on récupère les données pour la vue
        $result = array();

        // On vérifie qu'on a bien reçu des ingrédients
        if (!empty($fournisseurs)) {
            foreach ($fournisseurs as $fournisseur) {
                $result[] = array(
                    "id_fournisseur" => $fournisseur -> getId(),
                    "nom_fournisseur" => $fournisseur -> getNom()
                );
            }

            // tri des données pour la vue, on tri le tableau result en fonction du nom de l'ingrédient
            // note voir si on le fait sur le stock
            usort($result, function ($a, $b) {
                return $a['nom_fournisseur'] <=> $b['nom_fournisseur'];
            });
        }

        // envoi des données à la vue
        $view = new View(BaseTemplate::JSON);

        $view->json = $result;

        $view->renderView();

    }

    /**
     * Fonction permettant de récupérer tous les ingrédients et quantité lié à un bon de commande
     * 
     * @return void
     */
    public function refreshTableauIngredientsAJAX()
    {

        // On vérifie et on récupère les données du formulaire sous forme de json
        $rawData = Form::getParam('data', Form::METHOD_POST, Form::TYPE_MIXED);
        $data = json_decode($rawData, true);

        // on récupère tous les ingrédients
        $IngredientDAO = new IngredientDAO();
        $ingredients = $IngredientDAO->selectByIdCommandeForStock($data);

        // On vérifie qu'on a bien reçu des ingrédients
        if (!empty($ingredients)) {
            // on récupère les données pour la vue
            $result = array();
            foreach ($ingredients as $ingredient) {
                $result[] = array(
                    "id" => $ingredient["id_ingredient"],
                    "photo" => IMG . $ingredient["photo_ingredient"],
                    "nom" => $ingredient["nom_ingredient"],
                    "stock" => $ingredient["quantite_commande"],
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
