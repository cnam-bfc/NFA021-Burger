<link rel="stylesheet" href="<?php echo CSS; ?>Panier.css">
<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
<script src="<?php echo (JS) ?>Panier.js"></script>


<div class="wrapper axe_colonne text-center" id="AllPanier">
    <h2>Panier</h2>
    <div id="Panier">


    </div>
    <button onclick="commander()" class="animation-grow">Commander</button>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        console.log("html");
        showData();
    });
</script>