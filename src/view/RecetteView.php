<!-- On ajoute la feuille de style associé à la page -->
<link rel="stylesheet" href="<?php echo CSS ?>Recette.css">

<!-- Wrapper (contenu de la page) -->
<div class="padding_default grow">
    <h1 class="titre margin_left_right_auto">Recettes</h1>

    <!-- Tableau des recettes -->
    <table class="tableau padding_bottom_top_large" id="tableau_recettes">
        <thead>
            <tr>
                <th><!-- Image --></th>
                <th>Nom</th>
                <th>Description</th>
                <th>Ingrédients</th>
                <th>Prix</th>
                <th><!-- Bouton actions rapide --></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><img src="<?= IMG . 'recette/burger/cheddar_lover.webp' ?>"></td>
                <td>Cheddar lover</td>
                <td class="description">Le Big Mac™ est LE burger culte de McDonald’s, disponible dans de nombreux pays du monde ! Il a traversé les années et reste un indétrônable des burgers McDo™. Le secret de ce burger ? La simplicité de ses ingrédients, ses deux étages de saveurs, et bien entendu une sauce reconnaissable entre mille !</td>
                <td>
                    <li>2 steaks</li>
                    <li>2 fromages</li>
                    <li>2 salades</li>
                    <li>2 tomates</li>
                </td>
                <td>
                    8,99&nbsp;€
                </td>
                <td>
                    <div class="wrapper main_axe_center second_axe_center">
                        <button class="bouton"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="bouton"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </td>
            </tr>
            <tr>
                <td><img src="<?= IMG . 'recette/burger/steakhouse.webp' ?>"></td>
                <td>Steakhouse</td>
                <td class="description">Avec sa recette iconique : Un steak haché 100%* pur bœuf et 100% français, ses oignons frais, sa salade, ses tomates, le tout réhaussé par sa sauce inimitable à la moutarde à l'ancienne, le Royal™ Deluxe sait ravir vos papilles.</td>
                <td>
                    <li>1 steak français</li>
                    <li>1 fromage</li>
                    <li>1 salade</li>
                    <li>1 tomate</li>
                </td>
                <td>
                    14,99&nbsp;€
                </td>
                <td>
                    <div class="wrapper main_axe_center second_axe_center">
                        <button class="bouton"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="bouton"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </td>
            </tr>
            <tr>
                <td><img src="<?= IMG . 'recette/burger/triple_cheese.webp' ?>"></td>
                <td>Triple cheese</td>
                <td class="description">Un pain moelleux aux éclats de bacon, du poulet croustillant, des oignons frits et 3 tranches de bacon. Vous aussi craquez pour le CBO™.</td>
                <td>
                    <li>1 steak</li>
                    <li>3 fromages</li>
                    <li>1 salade</li>
                    <li>1 tomate</li>
                </td>
                <td>
                    12,99&nbsp;€
                </td>
                <td>
                    <div class="wrapper main_axe_center second_axe_center">
                        <button class="bouton"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="bouton"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6">
                    <button class="bouton" id="ajouter_ingredient"><i class="fa-solid fa-plus"></i> Ajouter une recette</button>
                </td>
            </tr>
        </tfoot>
    </table>
</div>