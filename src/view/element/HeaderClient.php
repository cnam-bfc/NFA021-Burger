<header class="header_client header_sticky">
    <nav class="nav_client">
        <ul>
            <li><a href=""><i class="fa-solid fa-bars fa-2x header_icone fa"></i></a></li>
            <li><a href="<?php echo PUBLIC_FOLDER ?>carte" class="header_nav_background_anim">Notre carte</a></li>
            <li><a href="" class="header_nav_background_anim">Nous trouver</a></li>
        </ul>
        <a href="<?php echo PUBLIC_FOLDER ?>"><img id="header_logo" src="<?= IMG ?>logo/logo.png"></a>
        <ul>
            <li class="wrapper axe_ligne second_axe_center">
                <?php
                // TODO Refaire ce code, ne va pas dans la vue
                $userSession = UserSession::getUserSession();
                if ($userSession->isLogged()) {
                ?>
                    <a href="<?php echo PUBLIC_FOLDER ?>profil"><i class="fa-solid fa-user fa-2x header_icone"></i></a>
                    <?php
                    if ($userSession->isClient()) {
                        $client = $userSession->getClientUser();
                        echo $client->getNom() . ' ' . $client->getPrenom();
                    } else if ($userSession->isEmploye()) {
                        $employe = $userSession->getEmployeUser();
                        echo $employe->getNom() . ' ' . $employe->getPrenom();
                    }
                    ?>
                    <a href="<?php echo PUBLIC_FOLDER ?>deconnexion"><i class="fa-solid fa-right-from-bracket fa-2x header_icone"></i></a>
                <?php } else { ?>
                    <a href="<?php echo PUBLIC_FOLDER ?>connexion"><i class="fa-solid fa-user fa-2x header_icone"></i></a>;
                <?php } ?>
            </li>
            <li><a href="<?php echo PUBLIC_FOLDER ?>panier"><i class="fa-solid fa-basket-shopping fa-2x header_icone"></i></a></li>
        </ul>
    </nav>
</header>