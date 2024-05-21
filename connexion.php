<?php
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Inclure le fichier d'initialisation de la base de données
        include_once "inc/init.php";

        $nom_utilisateur = $_POST['nom_utilisateur'];
        $mot_de_passe = $_POST['mot_de_passe'];

        // Récupérer le mot de passe haché de la base de données
        $stmt = $mysqli->prepare("SELECT mot_de_passe, est_approuve FROM utilisateurs WHERE nom_utilisateur = ?");
        $stmt->bind_param("s", $nom_utilisateur);
        $stmt->execute();
        $stmt->bind_result($mot_de_passe_base, $est_approuve);
        $stmt->fetch();
        $stmt->close();

        // Vérifier si le mot de passe fourni correspond au mot de passe haché
        if (password_verify($mot_de_passe, $mot_de_passe_base)) {
            // Mot de passe correct
            // Vérifier si le compte est approuvé
            if ($est_approuve == 1) {
                $_SESSION['admin_authentifie'] = true;
                header('Location: tableau_de_bord.php');
                exit();
            } else {
                echo '<p class="error">Votre compte n\'a pas encore été approuvé par l\'administrateur.</p>';
            }
        } else {
            echo '<p class="error">Nom d\'utilisateur ou mot de passe incorrect.</p>';
        }
    }
session_start();

if (isset($_SESSION['admin_authentifie'])) {
    // Déconnectez l'administrateur
    unset($_SESSION['admin_authentifie']);
}

// Redirigez vers la page de connexion
header('Location: connexion.php');

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Administrateur - Boulangerie Coin Chaud</title>
    <meta name="description" content="Connexion à l'espace administrateur de la Boulangerie Coin Chaud.">
    <meta name="keywords" content="connexion, administrateur, Boulangerie Coin Chaud, authentification">
    <meta name="robots" content="index, follow">    
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php include_once 'inc/head.php'; ?>

<section class="admin-login-page">
    <h2 class="admin-login-heading">Connexion Administrateur</h2>

    <form class="admin-login-form" method="post" action="connexion.php">
        <label for="nom_utilisateur">Nom d'Utilisateur :</label>
        <input type="text" name="nom_utilisateur" id="nom_utilisateur" required>
        <br><br>
        <label for="mot_de_passe">Mot de Passe :</label>
        <input type="password" name="mot_de_passe" id="mot_de_passe" required>
        <button type="button" onclick="togglePassword()">Afficher</button>
        <br><br>

        <input type="submit" value="Se connecter">
    </form>
</section>
<section class="admin-inscription">
    <a href="inscription.php">
        <button class="inscription-button">S'inscrire</button>
    </a>
</section>
<script>
function togglePassword() {
    var passwordInput = document.querySelector('input[name="mot_de_passe"]');
    var button = document.querySelector('.password-input button');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        button.textContent = 'Masquer';
    } else {
        passwordInput.type = 'password';
        button.textContent = 'Afficher';
    }
}
</script>
<?php include_once 'inc/foot.php'; ?>
</body>
</html>
