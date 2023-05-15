<link rel="stylesheet" href="<?php echo CSS; ?>CollectDelivery.css">
<script src="<?php echo (JS) ?>CollectDelivery.js"></script>


<div class="wrapper axe_colonne ">
    <div id="choice">
        <input type="checkbox" name="click_collect" id="bclick_collect" checked>
        <label for="click_collect">Click & Collect</label>

        <input type="checkbox" name="delivery" id="bdelivery">
        <label for="delivery">Delivery</label>
    </div>




    <div class="wrapper axe_ligne width_90 margin_auto " id="boxs">

        <!-- Boite de rensignement d'informations pour une Livraison -->
        <div class="box" id="delivery" style="display: none;">
            <h2 class="box_titre">Delivery</h2>
            <div class="box_contenu">
                <!-- Champ pour le code Postal-->
                <div class="form-input" >
                    <label for="cp">Code Postal</label>
                    <input type="text" id="cp" name="cp" placeholder="XX XXX" pattern="[0-9]{5}" required required>
                </div>
                <!-- Champ pour la ville -->
                <div class="form-input">
                    <label for="ville">Ville</label>
                    <input type="text" id="ville" name="ville" placeholder="city" required minlength=1 maxlength=250><?php if (isset($recetteDescription)) echo $recetteDescription; ?></textarea>
                </div>
                <!-- Champ pour la voie -->
                <div class="form-input">
                    <label for="voie">Voie</label>
                    <input type="text" id="voie" name="voie" placeholder="De Traumi" required>
                </div>
                <!-- Champ pour le n° de voie -->
                <div class="form-input">
                    <label for="numeroVoie">N° de Voie</label>
                    <input type="number" id="numeroVoie" name="numeroVoie" min="1" placeholder="21" required>
                </div>

                <!-- Boutton pour vérifier l'adresse -->
                <div>
                    <button>Verify adresse</button>
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
            <h2 class="box_titre">Click & Collect</h2>
            <div class="box_contenu">
                <!--Adresse du restaurant-->
                <p>14 Boulevard Magenta</p>

                <!--image du restaurant-->
                <img src="<?php echo IMG; ?>Logo/LogoElanChalonImage.png"></img>
                <div class="form-input">
                    <label for="heureCollect">Choisir une heure:</label>
                    <input type="time" id="heureCollect" name="heureCollect" min="<?php echo date('H:i', ceil(time() / 900) * 900); ?>" max="<?php echo date('H:i', floor(time() / 900) * 900 + 86400); ?>" step="900" required value="<?php echo date('H:i', ceil((time() + 1200) / 900) * 900); ?>">
                </div>
                <div class="form-input">
                    <label for="prenom">Votre Prénom :</label>
                    <input type="txt" id="prenom" name="prenom" pattern="[a-zA-Z\u00C0-\u024F\u1E00-\u1EFF\s-]+" required>
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