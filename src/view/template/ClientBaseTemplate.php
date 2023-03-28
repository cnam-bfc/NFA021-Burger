<!DOCTYPE html>
<html lang="fr">

<!-- Head -->
<?php require_once VIEW .'element' . DIRECTORY_SEPARATOR . 'Head.php' ?>

<body>
    <!-- Header -->
    <?php require_once VIEW . 'element' . DIRECTORY_SEPARATOR . 'HeaderClient.php' ?>

    <!-- Content -->
    <?php echo $templateContent ?>

    <!-- Footer -->
    <?php require_once VIEW . 'element' . DIRECTORY_SEPARATOR . 'FooterClient.php' ?>
</body>

</html>