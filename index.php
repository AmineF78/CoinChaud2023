<?php
include_once 'inc/init.php'; // Inclure le fichier d'initialisation de la base de données


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boulangerie Coin Chaud</title>
    <meta name="description" content="Boulangerie Coin Chaud - Découvrez notre délicieuse variété de pains, viennoiseries et gâteaux à des prix imbattables.">
    <meta name="keywords" content="boulangerie, pain, viennoiserie, gâteau, menu, horaires, contact">
    <meta name="robots" content="index, follow">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
</head>
<?php include_once 'inc/head.php'; ?>

<div class="consent-banner">
        <div class="consent-content">
            <p>Nous utilisons des cookies pour vous offrir la meilleure expérience sur notre site. En continuant, vous acceptez notre utilisation des cookies conformément à notre <a href="politique-de-confidentialite.php">politique de confidentialité</a>.</p>
            <button class="consent-button" onclick="accepterConsentement()">Accepter</button>
        </div>
</div>

    <section class="hero">
        <div class="hero-content">
            <h1>Bienvenue à la Boulangerie Coin Chaud</h1>
            <p>Nous vous offrons une délicieuse variété de pains, viennoiseries et gâteaux à des prix imbattables.</p>
        </div>
    </section>
<div class="container">
    <section class="sections">
        <h2 class="section-heading">Nos sections</h2>
        <div class="section-cards-1">
            <div class="section-card-1">
                <a href="menu.php">
                    <img src="images/menu.png" alt="Menu">
                    <h3>Menu</h3>
                </a>
            </div>
            <div class="section-card-1">
                <a href="horaire.php">
                    <img src="images/horaire.png" alt="Horaires">
                    <h3>Horaires</h3>
                </a>
            </div>
            <div class="section-card-1">
                <a href="contact.php">
                    <img src="images/contact.png" alt="Contactez-nous">
                    <h3>Contactez-nous</h3>
                </a>
            </div>
        </div>
        <h2 class="section-heading">Nos Produits</h2>

        <div class="best-sellers-container">
    <?php
    // Requête SQL pour récupérer les produits Best Sellers depuis la base de données
    $requete = "SELECT id, nom_produit FROM produits";
    $resultat = $mysqli->query($requete);

    if ($resultat->num_rows > 0) {
        while ($row = $resultat->fetch_assoc()) {
            // Créez un lien hypertexte autour du nom du produit pour rediriger vers la page du produit
            echo '<div class="section-card"><a href="produit.php?id=' . $row['id'] . '">';
            echo '<p>' . $row['nom_produit'] . '</p>';
            echo '</a>';
            echo '<form method="post">';
            echo '<input type="hidden" name="produit" value="' . $row['nom_produit'] . '">';
            echo '</form></div>';
        }
    } else {
        echo 'Aucun produit trouvé.';
    }
    ?>
</div>

        

    </section>
</div>
    <?php include_once 'inc/foot.php'; ?>

    <script>
        // Fonction pour accepter le consentement et masquer la bannière
        function accepterConsentement() {
            document.querySelector('.consent-banner').style.display = 'none';
        }
    </script> 
</body>
</html>
