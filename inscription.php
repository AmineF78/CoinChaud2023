<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<?php
include_once 'inc/head.php'; 

include 'inc/init.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_utilisateur = $_POST['nom_utilisateur'];
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);
    $demande_approbation = $_POST['demande_approbation'];

    // Vérifier si le nom d'utilisateur existe déjà
    $check_user_sql = "SELECT * FROM utilisateurs WHERE nom_utilisateur = ?";
    $check_user_stmt = $mysqli->prepare($check_user_sql);
    $check_user_stmt->bind_param("s", $nom_utilisateur);
    $check_user_stmt->execute();
    $check_user_result = $check_user_stmt->get_result();

    if ($check_user_result->num_rows > 0) {
        $message = "Ce nom d'utilisateur existe déjà. Veuillez en choisir un autre.";
    } else {
        // Vérifier la longueur du mot de passe
        $password = $_POST['mot_de_passe'];
        if (strlen($password) < 8) {
            $message = "Le mot de passe doit contenir au moins 8 caractères.";
        } else {
            // Utilisez une instruction préparée pour éviter les attaques par injection SQL
            $sql = "INSERT INTO utilisateurs (nom_utilisateur, mot_de_passe, demande_approbation) VALUES (?, ?, ?)";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ssi", $nom_utilisateur, $mot_de_passe, $demande_approbation);

            if ($stmt->execute()) {
                // Inscription réussie
                $message = "Inscription réussie !";
            } else {
                // Erreur lors de l'inscription
                $message = "Erreur lors de l'inscription : " . $stmt->error;
            }

            $stmt->close();
        }
    }
    $check_user_stmt->close();
}
?>

<!-- Contenu du formulaire -->
<section class="admin-inscription">
    <form action="inscription.php" method="post" class="admin-login-form">
        <label for="nom_utilisateur">Nom d'utilisateur :</label>
        <input type="text" name="nom_utilisateur" required>

        <label for="mot_de_passe">Mot de passe :</label>
        <div class="password-input">
            <input type="password" name="mot_de_passe" required>
            <button type="button" onclick="togglePassword()">Afficher</button>
        </div>

        <!-- Champ pour l'approbation manuelle -->
        <input type="hidden" name="demande_approbation" value="0">

        <input type="submit" value="S'inscrire" class="inscription-button">
    </form>

    <!-- Afficher le message -->
    <p class="message"><?php echo $message; ?></p>

    <!-- Bouton de redirection vers la page de connexion -->
    <a href="connexion.php" class="inscription-button">
        Se connecter
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
