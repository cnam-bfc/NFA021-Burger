<link rel="stylesheet" href="<?php echo CSS ?>GeneriqueTarek.css">
<link rel="stylesheet" href="<?php echo CSS ?>ListeBDC.css">
<link rel="stylesheet" href="<?php echo CSS ?>style.css">

<div id="wrapper">

    <h1 class='titre_page'>Liste des bon de commandes</h1><br>

    <div class="navigation">
        <button class="btn_navigation visible" data-page="1">BDC ouverts</button>
        <button class="btn_navigation" data-page="2">BDC clôturés</button>
        <button class="btn_navigation" data-page="3">BDC annulés</button>
    </div>

    <div class="conteneur_BDC">
        <div class="box_liste ouvert" data-page="1">
            <h2>BDC No 48</h2>
            <p>Fournisseur</p>
            <p>Montant TTC</p>
            <button class="btn_valider">Valider</button>
            <button class="btn_details">Détails</button>
        </div>

        <div class="box_liste ouvert" data-page="1">
            <h2>BDC No 49</h2>
            <p>Fournisseur</p>
            <p>Montant TTC</p>
            <button class="btn_valider">Valider</button>
            <button class="btn_details">Détails</button>
        </div>

        <div class="box_liste ouvert" data-page="1">
            <h2>BDC No 50</h2>
            <p>Fournisseur</p>
            <p>Montant TTC</p>
            <button class="btn_valider">Valider</button>
            <button class="btn_details">Détails</button>
        </div>

        <div class="box_liste ouvert" data-page="1">
            <h2>BDC No 50</h2>
            <p>Fournisseur</p>
            <p>Montant TTC</p>
            <button class="btn_valider">Valider</button>
            <button class="btn_details">Détails</button>
        </div>

        <div class="box_liste cloture" data-page="2">
            <h2>BDC No 26</h2>
            <p>Fournisseur</p>
            <p>Montant TTC</p>
            <button class="btn_details">Détails</button>
        </div>

        <div class="box_liste cloture" data-page="2">
            <h2>BDC No 27</h2>
            <p>Fournisseur</p>
            <p>Montant TTC</p>
            <button class="btn_details">Détails</button>
        </div>

        <div class="box_liste cloture" data-page="2">
            <h2>BDC No 28</h2>
            <p>Fournisseur</p>
            <p>Montant TTC</p>
            <button class="btn_details">Détails</button>
        </div>

        <div class="box_liste annule" data-page="3">
            <h2>BDC No 29</h2>
            <p>Fournisseur</p>
            <p>Montant TTC</p>
            <button class="btn_details">Détails</button>
        </div>

        <div class="box_liste annule" data-page="3">
            <h2>BDC No 30</h2>
            <p>Fournisseur</p>
            <p>Montant TTC</p>
            <button class="btn_details">Détails</button>
        </div>

        <div class="box_liste annule" data-page="3">
            <h2>BDC No 31</h2>
            <p>Fournisseur</p>
            <p>Montant TTC</p>
            <button class="btn_details">Détails</button>
        </div>

    </div>
</div><br><br>

<script src="<?php echo JS ?>ListeBDC.js"></script>