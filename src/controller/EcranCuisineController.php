<?php

class EcranCuisineController extends Controller
{
    public function listeCommandes()
    {
        // Création des objets DAO
        $recetteDAO = new RecetteDAO();
        $recetteFinaleDAO = new RecetteFinaleDAO();
        $recetteFinaleIngredientDAO = new RecetteFinaleIngredientDAO();
        $ingredientDAO = new IngredientDAO();
        $commandeClientRetraitDao = new CommandeClientRetraitDAO();
        $commandeClientLivraisonDao = new CommandeClientLivraisonDAO();

        // Création du json
        $json = array();
        $json['data'] = array();

        // Récupération de la recette

        $recettes = $recetteDAO->selectAll();

        $numeroCommande = 1;

        // Récupération des ingrédients
        $ingredients = $ingredientDAO->selectAll();

        // Récupération des commandes clients
        $commandeClientRetrait = $commandeClientRetraitDao->selectAllNonArchiveNonPret();
        $commandeClientLivraison = $commandeClientLivraisonDao->selectAllNonArchiveNonPret();


        foreach ($commandeClientRetrait as $cmd) {
            // Récupération des recettes finales
            $recettesFinales = $recetteFinaleDAO->selectAllByIdCommandeClient($cmd->getId());

            $jsonRecetteFinales = array();

            $jsonRecetteFinaleIngredients = array();

            foreach ($recettesFinales as $recetteFinale) {
                /** @var RecetteFinale $recetteFinale */
                $recette = null;
                // Récupération de la recette
                foreach ($recettes as $recetteTmp) {
                    if ($recetteTmp->getId() === $recetteFinale->getIdRecette()) {
                        $recette = $recetteTmp;
                        break;
                    }
                }

                // Si la recette n'existe pas, on passe à la recette suivante
                if ($recette === null) {
                    continue;
                }

                // Récupération des ingrédients de la recette finale
                $recetteFinaleIngredients = $recetteFinaleIngredientDAO->selectAllByIdRecetteFinale($recetteFinale->getId());

                foreach ($recetteFinaleIngredients as $recetteFinaleIngredient) {
                    /** @var RecetteFinaleIngredient $recetteFinaleIngredient */
                    $ingredient = null;
                    // Récupération de l'ingrédient
                    foreach ($ingredients as $ingredientTmp) {
                        if ($ingredientTmp->getId() === $recetteFinaleIngredient->getIdIngredient()) {
                            $ingredient = $ingredientTmp;
                            break;
                        }
                    }

                    // Si l'ingrédient n'existe pas, on passe à l'ingrédient de la recette suivant
                    if ($ingredient === null) {
                        continue;
                    }
                    //Formatage des ingrédients finaux en json
                    $jsonRecetteFinaleIngredients[] = array(
                        'id' => $ingredient->getId(),
                        'nom' => $ingredient->getNom(),
                        'ordre' => $recetteFinaleIngredient->getOrdre(),
                        'quantite' => $recetteFinaleIngredient->getQuantite(),
                    );
                }
                //Formatage des recettes finales en json
                $jsonRecetteFinales[] = array(
                    'id' => $recetteFinale->getId(),
                    'nom' => $recette->getNom(),
                    'quantite' => $recetteFinale->getQuantite(),
                    'ingredients' => $jsonRecetteFinaleIngredients,
                );

            }

            //Attribution d'un numéro de commande
             // Exemple avec le numéro initial 1

            // Augmenter le numéro de commande de 1
            $numeroCommande++;

            // Vérifier si le numéro de commande dépasse 1000
            if ($numeroCommande > 1000) {
                $numeroCommande = 1; // Revenir à 1 si le numéro dépasse 1000
            }

            //Formatage des commandes en json
            $jsonCommandeRetrait = array(
                'id' => $cmd->getId(),
                'prix' => $cmd->getPrix(),
                'date_pret' => $cmd->getDatePret(),
                'date_remise' => $cmd->getHeureRetrait(),
                'date_archive' => $cmd->getDateArchive(),
                'recettes' => $jsonRecetteFinales,
            );

            $json['data'][] = $jsonCommandeRetrait;
        }

        foreach ($commandeClientLivraison as $cmd) {
            // Récupération des recettes finales
            $recettesFinales = $recetteFinaleDAO->selectAllByIdCommandeClient($cmd->getId());

            $jsonRecetteFinales = array();

            $jsonRecetteFinaleIngredients = array();

            foreach ($recettesFinales as $recetteFinale) {
                /** @var RecetteFinale $recetteFinale */
                $recette = null;
                // Récupération de la recette
                foreach ($recettes as $recetteTmp) {
                    if ($recetteTmp->getId() === $recetteFinale->getIdRecette()) {
                        $recette = $recetteTmp;
                        break;
                    }
                }

                // Si la recette n'existe pas, on passe à la recette suivante
                if ($recette === null) {
                    continue;
                }

                // Récupération des ingrédients de la recette finale
                $recetteFinaleIngredients = $recetteFinaleIngredientDAO->selectAllByIdRecetteFinale($recetteFinale->getId());

                foreach ($recetteFinaleIngredients as $recetteFinaleIngredient) {
                    /** @var RecetteFinaleIngredient $recetteFinaleIngredient */
                    $ingredient = null;
                    // Récupération de l'ingrédient
                    foreach ($ingredients as $ingredientTmp) {
                        if ($ingredientTmp->getId() === $recetteFinaleIngredient->getIdIngredient()) {
                            $ingredient = $ingredientTmp;
                            break;
                        }
                    }

                    // Si l'ingrédient n'existe pas, on passe à l'ingrédient de la recette suivant
                    if ($ingredient === null) {
                        continue;
                    }
                    //Formatage des ingrédients finaux en json
                    $jsonRecetteFinaleIngredients[] = array(
                        'id' => $ingredient->getId(),
                        'nom' => $ingredient->getNom(),
                        'ordre' => $recetteFinaleIngredient->getOrdre(),
                        'quantite' => $recetteFinaleIngredient->getQuantite(),
                    );
                }
                //Formatage des recettes finales en json
                $jsonRecetteFinales[] = array(
                    'id' => $recetteFinale->getId(),
                    'nom' => $recette->getNom(),
                    'quantite' => $recetteFinale->getQuantite(),
                    'ingredients' => $jsonRecetteFinaleIngredients,
                );

            }



            //Récupération de l'heure de livraison de la commande


            //Formatage des commandes en json
            $jsonCommandeLivraison = array(
                'id' => $cmd->getId(),
                'prix' => $cmd->getPrix(),
                'date_pret' => $cmd->getDatePret(),
                'date_remise' => $cmd->getHeureLivraison(),
                'date_archive' => $cmd->getDateArchive(),
                'recettes' => $jsonRecetteFinales,
            );

            $json['data'][] = $jsonCommandeLivraison;
        }

        usort($json['data'], function ($a, $b) {
            return $a['date_remise'] <=> $b['date_remise'];
        });

        // Tri des ingrédients par ordre


        $view = new View(BaseTemplate::JSON);

        $view->json = $json;

        $view->renderView();
    }

    public function renderView()
    {
        $view = new View(BaseTemplate::CUISINIER, 'EcranCuisineView');
        $view->renderView();
    }
}
