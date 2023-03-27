<!DOCTYPE html>
<html lang="fr">

<!-- Head -->
<?php require_once 'Head.php' ?>

<body>
    <!-- Header -->
    <?php require_once VIEW . 'element' . DIRECTORY_SEPARATOR . 'HeaderEmploye.php' ?>

    <!-- Content -->
    <?php echo $templateContent ?>

    <!-- Footer -->
    <?php require_once VIEW . 'element' . DIRECTORY_SEPARATOR . 'FooterEmploye.php' ?>
</body>

</html>