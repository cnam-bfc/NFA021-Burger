const panier = document.getElementById('Panier');
function showData() {

    panier.innerHTML = $_SESSION['panier'];
    for (let index = 0; index < <?php echo $_SESSION['panier']['ingredientsFinaux'].length?>; index + 2) {
        let p = document.createElement("p");
        p.textContent = <?php echo $_SESSION["panier"]['ingredientsFinaux'][index]; ?>;
        panier.appendChild();

    }

};
