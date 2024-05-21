<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boulangerie Coin Chaud</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
</head>
<body>
    <!-- Reste du contenu de votre en-tête (bannière, etc.) -->

    <!-- Ajoutez le bouton de menu mobile -->
    
    <header class="navbar">
        <div class="logo">
            <h1>Coin Chaud</h1>
        </div>
        <button class="mobile-menu-button" onclick="toggleMobileMenu()">
        <i class="fas fa-bars"></i>
    </button>
    <nav class="menu">
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="horaire.php">Horaires</a></li>
                <li><a href="contact.php">Contactez-nous</a></li>
                <li><a href="connexion.php">Admin</a></li> <!-- Lien vers la page d'administration -->
            </ul>
        </nav>
    </header>
    <script>
        function toggleMobileMenu() {
            var navbar = document.querySelector('.navbar');
            navbar.classList.toggle('mobile');
            navbar.classList.toggle('show-menu');
        }
        
    </script>
