<?php

/**
 * DAO CommandeClient
 */
class AccueilTextDAO extends DAO
{
    /**
     * Méthode permettant de créer un objet
     * 
     * @param AccueilText $accueilText (objet à créer qui ne possède pas d'id, celui-ci sera affecté par la méthode)
     * @throws Exception (si l'objet possède déjà un id)
     */
    public function create($accueilText)
    {
        // Vérification que l'objet n'a pas d'id
        if ($accueilText->getId() !== null) {
            throw new Exception("L'objet à créer ne doit pas avoir d'id");
        }

        // On récupère le json AccueilText.json
        $json = file_get_contents(SRC_DATA_FOLDER. "AccueilText.json");
        // On décode le json
        $json_data = json_decode($json, true);

        // on regarde le counter et on l'incremente, cela nous donnera en passant le nouvel id
        $counter = $json_data['counter'];
        $counter++;

        // On met à jour le json
        $json_data['counter'] = $counter;
        $json_data['accueilTexts'][$counter] = array(
            'title' => $accueilText->getTitle(),
            'text' => $accueilText->getText()
        );

        // On encode la structure de données en JSON
        $updated_json = json_encode($json_data);

        // On écrit le JSON mis à jour dans le fichier AccueilText.json
        file_put_contents("data/AccueilText.json", $updated_json);
    }

    /**
     * Méthode permettant de supprimer un objet
     * 
     * @param AccueilText $accueilText (objet à supprimer)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function delete($accueilText)
    {
        // Vérification que l'objet a un id
        if ($accueilText->getId() === null) {
            throw new Exception("L'objet à supprimer doit avoir un id");
        }

        // On récupère le json AccueilText.json
        $json = file_get_contents(SRC_DATA_FOLDER. "AccueilText.json");
        // On décode le json
        $json_data = json_decode($json, true);

        // On supprime l'élément du tableau
        unset($json_data['texts'][$accueilText->getId()]);

        // On encode la structure de données en JSON
        $updated_json = json_encode($json_data);

        // On écrit le JSON mis à jour dans le fichier AccueilText.json
        file_put_contents("data/AccueilText.json", $updated_json);
    }

    /**
     * Méthode permettant de mettre à jour un objet
     * 
     * @param AccueilText $accueilText (objet à mettre à jour)
     * @throws Exception (si l'objet n'a pas d'id)
     */
    public function update($accueilText)
    {
        // Vérification que l'objet a un id
        if ($accueilText->getId() === null) {
            throw new Exception("L'objet à mettre à jour doit avoir un id");
        }

        // On récupère le json AccueilText.json
        $json = file_get_contents(SRC_DATA_FOLDER. "AccueilText.json");
        // On décode le json
        $json_data = json_decode($json, true);

        // On récupère l'élément du json en fonction de l'id
        $json_data['texts'][$accueilText->getId()] = array(
            'title' => $accueilText->getTitle(),
            'text' => $accueilText->getText()
        );

        // On encode la structure de données en JSON
        $updated_json = json_encode($json_data);

        // On écrit le JSON mis à jour dans le fichier AccueilText.json
        file_put_contents("data/AccueilText.json", $updated_json);
    }

    /**
     * Méthode permettant de récupérer tous les objets
     * 
     * @return AccueilText[] (tableau d'objets)
     */
    public function selectAll()
    {
        // On récupère le json AccueilText.json
        $json = file_get_contents(SRC_DATA_FOLDER. "AccueilText.json");
        // On décode le json
        $json_data = json_decode($json, true);

        // On récupère le tableau des accueilTexts
        $accueilTexts = $json_data['texts'];

        // On crée un tableau qui contiendra tous les objets AccueilText
        $accueilTextsArray = array();

        // On parcourt le tableau des accueilTexts
        foreach ($accueilTexts as $key => $value) {
            // On crée un nouvel objet AccueilText
            $accueilText = new AccueilText();

            // On remplit l'objet avec les données du tableau
            $this->fillObject($accueilText, $value);

            $accueilTextsArray[] = $accueilText;
        }

        return $accueilTextsArray;
    }

    /**
     * Méthode permettant de récupérer un objet par son id
     * 
     * @param string $id (id de l'objet à récupérer)
     * @return AccueilText|null (objet ou null si aucun objet trouvé)
     */
    public function selectById($id)
    {
        // On récupère le json AccueilText.json
        $json = file_get_contents(SRC_DATA_FOLDER. "AccueilText.json");
        // On décode le json
        $json_data = json_decode($json, true);

        // On récupère le tableau des accueilTexts
        $accueilTexts = $json_data['texts'];

        // On parcourt le tableau des accueilTexts
        foreach ($accueilTexts as $key => $value) {
            // Si l'id correspond à celui passé en paramètre
            if ($key == $id) {
                // On crée un nouvel objet AccueilText
                $accueilText = new AccueilText();

                // On remplit l'objet avec les données du tableau
                $this->fillObject($accueilText, $value);
                
                return $accueilText;
            }
        }
        return null;
    }

    /**
     * Méthode qui permet de retourner un text au hasard
     *
     * @return AccueilText/null
     */
    public function selectRandomText() {
        // On récupère le json AccueilText.json
        $json = file_get_contents(SRC_DATA_FOLDER. "AccueilText.json");
        // On décode le json
        $json_data = json_decode($json, true);

        // On récupère le tableau des accueilTexts
        $accueilTexts = $json_data['texts'];

        // On récupère le nombre d'éléments dans le tableau
        $nbElements = count($accueilTexts);

        // On récupère un nombre aléatoire entre 0 et le nombre d'éléments
        $randomNumber = rand(1, $nbElements);

        // on récupère le text correspondant au nombre aléatoire et on remplie un objet
        $accueilText = new AccueilText();
        $this->fillObject($accueilText, $accueilTexts[$randomNumber]);
        return $accueilText;
    }

    /**
     * Méthode permettant de remplir un objet à partir d'un tableau (ligne issue de la base de données)
     * 
     * @param AccueilText $accueilText (objet à remplir)
     * @param array $row (tableau contenant les données)
     */
    public function fillObject($accueilText, $row)
    {
        $accueilText->setId($row['id']);
        $accueilText->setTitle($row['title']);
        $accueilText->setText($row['text']);
    }
}
