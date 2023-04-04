<!-- Ajout du css associé à la page -->
<link rel="stylesheet" href="<?= CSS ?>Error.css">

<div class="wrapper axe_colonne second_axe_center margin_bottom_top_large ">
    <img src="<?= IMG ?>ingredient/coupe/top_burger.webp" alt="404" id="error_top">
    <h1 id="error_message" class= "bold font_size_large"><?= $code . ' - ' . $message ?></h1>
    <img src="<?= IMG ?>ingredient/coupe/bot_burger.webp" alt="404" id="error_bottom">
</div>