<?php require_once 'inc/init.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Menu</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <?php include_once 'inc/head.php'; ?>

    <h1 class="menu-heading">Menu</h1>

    <div class="menu-items">
        <?php
        // Utilisez la connexion à la base de données depuis votre fichier init.php
        $sql = "SELECT id, nom_produit, description_produit FROM produits";
        $result = mysqli_query($mysqli, $sql);

        // Affichez les produits
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $nom = $row['nom_produit'];
            $description = $row['description_produit'];

            echo '<div class="menu-item">';
            echo "<h2>$nom</h2>";
            echo "<p>$description</p>";
            echo "<a href='produit.php?id=$id' class='menu-item-link'>Voir les détails</a>";
            echo '</div>';
        }
        ?>
    </div>

    <?php include_once 'inc/foot.php'; ?>

</body>
</html>
