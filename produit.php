<?php
// Inclure le fichier d'initialisation de la base de données
require_once 'inc/init.php';

// Vérifier si l'ID du produit est passé en paramètre
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_produit = $_GET['id'];

    // Requête SQL pour récupérer les détails du produit depuis la base de données
    $sql = "SELECT * FROM produits WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $id_produit);

    if ($stmt->execute()) {
        $resultat = $stmt->get_result();
        if ($resultat->num_rows === 1) {
            $produit = $resultat->fetch_assoc();
        } else {
            // Gérer le cas où le produit n'est pas trouvé
            echo "Produit non trouvé.";
        }
    } else {
        // Gérer les erreurs d'exécution de la requête
        echo "Erreur lors de la récupération du produit : " . $stmt->error;
    }
    $stmt->close();
} else {
    // Gérer le cas où l'ID du produit n'est pas spécifié
    echo "ID du produit non spécifié.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Produit</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include_once 'inc/head.php'; ?>

    <section class="produit-details">
        <h2 class="produit-details-heading">Détails du Produit</h2>
        <?php if (isset($produit)) : ?>
            <h3> <?php echo $produit['nom_produit']; ?></h3>
            <p> <?php echo $produit['description_produit']; ?></p>
            <p> <?php echo $produit['prix_produit']; ?> €</p>
        <?php else : ?>
            <p class="product-not-found">Le produit n'a pas été trouvé.</p>
        <?php endif; ?>
    </section>

<?php include_once 'inc/foot.php'; ?>
</body>
</html>
