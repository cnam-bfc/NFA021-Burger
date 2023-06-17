<?php

class RecapController extends Controller
{
    public function renderViewRecap()
    {
        $view = new View(BaseTemplate::CLIENT, 'RecapView');


        $view->renderView();
    }
    public function getRecapInfos()
    {
        $infosJSON = $_SESSION['infosRecupCommande'];

        $view = new View(BaseTemplate::JSON, null);
        $view->json = $infosJSON;
        $view->renderView();
    }
    public function writeOnBDD()
    {
        $succes = false;

        try {
            Database::getInstance()->getPDO()->beginTransaction();

            $userSession = UserSession::getUserSession();
            if ($userSession->isLogged() && $userSession->isClient()) {
                $clientDAO = new ClientDAO();

                // Récupération du client
                $client = $clientDAO->selectById($userSession->getCompte()->getId());

                if ($client !== null) {
                    // Traitement
                }
            }

            if (isset($_POST['tabCommandeClientRetrait'])) {
                $retraitDAO = new CommandeClientRetraitDAO();
                $retrait = new CommandeClientRetrait();

                $retrait->setDateCommande(date('Y-m-d H:i:s'));
                $retrait->setPrix($_POST['tabCommandeClientRetrait']['prix']);
                $retrait->setHeureRetrait(date("Y-m-d ") . $_POST['tabCommandeClientRetrait']['heure Retrait'] . ":00");
                if ($_POST['tabCommandeClientRetrait']['emballage'] == "carton") {
                    $retrait->setIdEmballage(1);
                } else {
                    $retrait->setIdEmballage(2);
                }
                $retrait->setIdClient($client->getId());
                $retraitDAO->create($retrait);

                $idCommandeClient = $retrait->getId();
            } elseif (isset($_POST['tabCommandeClientLivraison'])) {
                $livraisonDAO  = new CommandeClientLivraisonDAO();
                $livraison = new CommandeClientLivraison();

                $livraison->setHeureLivraison(date("Y-m-d ") . $_POST['tabCommandeClientLivraison']["heure Livraison"] . ":00");
                $livraison->setAdresseOsmType($_POST['tabCommandeClientLivraison']["osm type"]);
                $livraison->setAdresseOsmId($_POST['tabCommandeClientLivraison']["osm id"]);
                $livraison->setAdresseCodePostal($_POST['tabCommandeClientLivraison']["code postal"]);
                $livraison->setAdresseVille($_POST['tabCommandeClientLivraison']["ville"]);
                $livraison->setAdresseRue($_POST['tabCommandeClientLivraison']["rue"]);
                if ($_POST['tabCommandeClientLivraison']["numero voie"] != 'NaN') {
                    $livraison->setAdresseNumero($_POST['tabCommandeClientLivraison']["numero voie"]);
                }
                $livraison->setPrix($_POST['tabCommandeClientLivraison']["prix"]);
                $livraison->setPrix($_POST['tabCommandeClientLivraison']["prix"]);
                $livraison->setDateCommande(date('Y-m-d H:i:s'));

                $livraison->setIdClient($client->getId());
                $livraison->setIdEmballage(2);



                $livraisonDAO->create($livraison);

                //c'est l'id de burger_commande_client
                $idCommandeClient = $livraison->getId();

                //réponse de la requête

            }

            //créer burger recette finale pour chaque recette
            $panier = $_POST["panier"];


            foreach ($panier as $burger) {
                if ($burger != null) {
                    $recetteFinaleDAO  = new RecetteFinaleDAO();
                    $recetteFinale = new RecetteFinale();

                    $recetteFinale->setIdRecette($burger["idRecette"]);
                    $recetteFinale->setIdCommandeClient($idCommandeClient);
                    $recetteFinale->setQuantite(1);

                    $recetteFinaleDAO->create($recetteFinale);
                    $idRecetteFinale = $recetteFinale->getId();


                    for ($i = 0; $i < count($burger["ingredientsFinaux"]); $i++) {

                        if (count($burger["ingredientsFinaux"][$i]) > 1) {

                            $FinalIngrDAO  = new RecetteFinaleIngredientDAO();
                            $FinalIngr = new RecetteFinaleIngredient();

                            $FinalIngr->setOrdre($i + 1);
                            $FinalIngr->setQuantite(intval($burger["ingredientsFinaux"][$i]["quantite"]));
                            $FinalIngr->setIdIngredient($burger["ingredientsFinaux"][$i]["id"]);
                            $FinalIngr->setIdRecetteFinale($idRecetteFinale);


                            $burger["ingredientsFinaux"][$i];

                            $FinalIngrDAO->create($FinalIngr);
                        }
                    }
                }
            }


            //créer burger_recette_finale_ingrédient pour chaque ingrédient de chaque burger



            Database::getInstance()->getPDO()->commit();

            unset($_SESSION['panier']);

            $succes = true;
        } catch (PDOException $e) {
            // En cas d'erreur, annuler la transaction
            Database::getInstance()->getPDO()->rollBack();

            echo "Erreur lors de la transaction : " . $e->getMessage();

            //réponse de la requête
            $succes = false;
        }

        $view = new View(BaseTemplate::JSON, null);
        $view->json = $succes;
        $view->renderView();
    }
}
