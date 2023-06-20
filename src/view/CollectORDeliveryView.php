<link rel="stylesheet" href="<?php echo CSS; ?>CollectDelivery.css">
<script src="<?php echo (JS) ?>CollectDelivery.js"></script>


<div class="wrapper axe_colonne ">
    <div id="choice" class="width_90 margin_auto">
        <input type="button" name="click_collect" id="bclick_collect" value="Retrait en Restaurant">


        <input type="button" name="delivery" id="bdelivery" value="Livraison">

    </div>


    <div id="custom-cursor"></div>


    <div class="wrapper axe_ligne width_90 margin_auto " id="boxs">

        <!-- Boite de rensignement d'informations pour une Livraison -->
        <div class="box" id="delivery" style="display: none;">
            <h2 class="box_titre">Livraison</h2>
            <div class="box_contenu">
                <!-- Champ pour l'adresse du client-->
                <div class="form-input">
                    <label for="adresse">Adresse</label>
                    <input type="text" id="adresse" name="adresse" placeholder="Adresse complète" required>
                    <div id="suggestions"></div>
                </div>

                <!-- Champ pour le numéro de téléphone du client-->
                <div class="form-input">
                    <label for="telephone">Téléphone</label>
                    <input type="txt" id="telephone" name="telephone" pattern="^0[0-9]{9}" placeholder="0612345678" required>

                </div>
                <!-- Boutton pour vérifier le numéro de téléphone -->
                <button>Verify Number</button>
                <div class="form-input">
                    <label for="heureDelivery">Choisir une heure:</label>
                    <input type="time" id="heureDelivery" name="heureDelivery" min="<?php echo date('H:i', ceil(time() / 900) * 900); ?>" max="<?php echo date('H:i', floor(time() / 900) * 900 + 86400); ?>" step="900" required value="<?php echo date('H:i', ceil((time() + 1200) / 900) * 900); ?>">
                </div>
            </div>
        </div>

        <!-- Boite de rensignement d'informations pour une Collecte en restaurant -->
        <div class="box" id="clickCollect">
            <h2 class="box_titre">Retrait en Restaurant</h2>
            <div class="box_contenu">
                <div class="form-input">
                    <label for="heureCollect">Choisir une heure :</label>
                    <select id="heureCollect" name="heureCollect" required>
                    </select>

                    <script>
                        // Date actuelle
                        let heure = new Date();
                        // On récupère l'heure actuelle au quart d'heure supérieur
                        heure.setMinutes(Math.ceil(heure.getMinutes() / 15) * 15);

                        // On affiche les 12 prochains quarts d'heure
                        for (let i = 0; i < 12; i++) {
                            let heureTimestamp = heure.getTime();
                            let heureString = heure.getHours() + ":" + heure.getMinutes();
                            if (heure.getMinutes() < 10) {
                                heureString += "0";
                            }
                            // On ajoute une option au select
                            document.getElementById("heureCollect").innerHTML += "<option value='" + heureTimestamp + "'>" + heureString + "</option>";
                            // On ajoute 15 minutes à l'heure
                            heure.setMinutes(heure.getMinutes() + 15);
                        }
                    </script>



                </div>
                <div class="form-input">
                    <label for="prenom">Votre Prénom :</label>
                    <input type="txt" id="prenom" name="prenom" pattern="[a-zA-Z\u00C0-\u024F\u1E00-\u1EFF\s-]+" required>
                </div>
                <div class="form-input">
                    <label for="emballage">Choisissez un type d'emballage :</label>
                    <select id="emballage" name="emballage">
                        <option value="carton">Carton</option>
                        <option value="isotherme">Isotherme</option>
                    </select>



                </div>


            </div>
        </div>
        <!-- Boite de renseignement d'informations pour le paiement -->
        <div class="box" id="paiement">
            <h2 class=" box_titre">Paiement</h2>
            <div class="box_contenu">
                <!-- Champ pour le N° de la carte-->
                <div class="form-input">
                    <label for="numeroCarte">N° de Carte</label>
                    <input type="txt" id="numeroCarte" name="numeroCarte" pattern="[0-9]{16}" required>

                </div>
                <!-- Champ pour la date d'expiration de la carte-->
                <div class="form-input">
                    <label for="carteExpiration">Date d'expiration</label>
                    <input type="month" id="carteExpiration" name="carteExpiration" required>

                </div>
                <!-- Champ pour le Nom du titulaire de la carte-->
                <div class="form-input">
                    <label for="nomCarte">Nom Titulaire</label>
                    <input type="txt" id="nomCarte" name="nomCarte" required>
                </div>
                <!-- Champ pour le numéro de sécurité de la carte-->
                <div class="form-input">
                    <label for="numeroSecur">N° de Sécurité</label>
                    <input type="txt" id="numeroSecur" name="numeroSecur" pattern="[0-9]{3}" required>

                </div>
            </div>
        </div>
    </div>
    <div id="boutonSoumettre">
        <button onclick="valider()">Soumettre</button>
    </div>


</div>