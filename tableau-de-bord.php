<?php
session_start();

// Vérifier l'authentification de l'administrateur
if (!isset($_SESSION['admin_authentifie']) || $_SESSION['admin_authentifie'] !== true) {
    header('Location: connexion.php');
    exit();
}

include "inc/init.php";

$message = $erreur = '';

// Ajouter un produit
if (isset($_POST['ajouter_produit'])) {
    $nom_produit = $_POST['nom_produit'];
    $description_produit = $_POST['description_produit'];
    $prix_produit = $_POST['prix_produit'];

    $sql = "INSERT INTO produits (nom_produit, description_produit, prix_produit) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssd", $nom_produit, $description_produit, $prix_produit);

    if ($stmt->execute()) {
        $message = "Produit ajouté avec succès.";
    } else {
        $erreur = "Erreur lors de l'ajout du produit : " . $stmt->error;
    }

    $stmt->close();
}

// Supprimer un produit
if (isset($_POST['supprimer_produit_action'])) {
    $produit_id = $_POST['supprimer_produit_id'];

    $sql = "DELETE FROM produits WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $produit_id);

    if ($stmt->execute()) {
        $message = "Produit supprimé avec succès.";
    } else {
        $erreur = "Erreur lors de la suppression du produit : " . $stmt->error;
    }

    $stmt->close();
}

// Modifier un produit
if (isset($_POST['modifier_produit_action'])) {
    $produit_id = $_POST['modifier_produit_id'];

    // Récupérer les détails du produit à partir de la base de données
    $sql_select = "SELECT * FROM produits WHERE id = ?";
    $stmt_select = $mysqli->prepare($sql_select);
    $stmt_select->bind_param("i", $produit_id);
    $stmt_select->execute();
    $result_select = $stmt_select->get_result();

    if ($result_select->num_rows > 0) {
        $row_produit = $result_select->fetch_assoc();

        // Afficher le formulaire pré-rempli avec les détails du produit
        echo '<form method="post" action="tableau_de_bord.php" class="modifier_produit">
            <h3>Modifier un Produit</h3>
                <input type="hidden" name="modifier_produit_id" value="' . $row_produit['id'] . '">
                <input type="text" name="nouveau_nom_produit" placeholder="Nouveau nom du produit" value="' . $row_produit['nom_produit'] . '" required>
                <input type="text" name="nouvelle_description_produit" placeholder="Nouvelle description" value="' . $row_produit['description_produit'] . '" required>
                <input type="number" name="nouveau_prix_produit" placeholder="Nouveau prix" step="0.01" value="' . $row_produit['prix_produit'] . '" required>
                <button type="submit" name="valider_modification_produit">Valider la modification</button>
              </form>';
    } else {
        $erreur = "Produit non trouvé.";
    }

    $stmt_select->close();
}

// Valider la modification d'un produit
if (isset($_POST['valider_modification_produit'])) {
    $produit_id = $_POST['modifier_produit_id'];
    $nouveau_nom_produit = $_POST['nouveau_nom_produit'];
    $nouvelle_description_produit = $_POST['nouvelle_description_produit'];
    $nouveau_prix_produit = $_POST['nouveau_prix_produit'];

    $sql = "UPDATE produits SET nom_produit = ?, description_produit = ?, prix_produit = ? WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssdi", $nouveau_nom_produit, $nouvelle_description_produit, $nouveau_prix_produit, $produit_id);

    if ($stmt->execute()) {
        $message = "Produit modifié avec succès.";
    } else {
        $erreur = "Erreur lors de la modification du produit : " . $stmt->error;
    }

    $stmt->close();
}

// Approuver une demande
if (isset($_POST['approuver_demande'])) {
    $utilisateur_id = $_POST['utilisateur_id'];

    $sql = "UPDATE utilisateurs SET est_approuve = 1, demande_approbation = 1 WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $utilisateur_id);

    if ($stmt->execute()) {
        $message = "Demande approuvée avec succès.";
    } else {
        $erreur = "Erreur lors de l'approbation de la demande : " . $stmt->error;
    }

    $stmt->close();
}

// Supprimer une demande
if (isset($_POST['supprimer_demande_action'])) {
    $utilisateur_id = $_POST['supprimer_demande_id'];

    $sql = "DELETE FROM utilisateurs WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $utilisateur_id);

    if ($stmt->execute()) {
        $message = "Demande supprimée avec succès.";
    } else {
        $erreur = "Erreur lors de la suppression de la demande : " . $stmt->error;
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script>
        function confirmerSuppression() {
            return confirm("Êtes-vous sûr de vouloir supprimer ?");
        }
    </script>
</head>
<body>
    <div class="dashboard">
        <h2>Tableau de Bord Administrateur</h2>

        <a href="index.php">Accueil</a>
        <a href="deconnexion.php">Se déconnecter</a>

        <form method="post">
            <h3>Ajouter un Produit</h3>
            <input type="text" name="nom_produit" placeholder="Nom du produit" required>
            <input type="text" name="description_produit" placeholder="Description" required>
            <input type="number" name="prix_produit" placeholder="Prix" step="0.01" required>
            <button type="submit" name="ajouter_produit">Ajouter</button>
        </form>

        <h3>Liste des Produits</h3>
        <table>
            <tr>
                <th>Nom</th>
                <th>Description</th>
                <th>Prix</th>
                <th>Actions</th>
            </tr>

            <?php
            $query = "SELECT * FROM produits";
            $result = $mysqli->query($query);

            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['nom_produit'] . "</td>";
                    echo "<td>" . $row['description_produit'] . "</td>";
                    echo "<td>" . $row['prix_produit'] . "</td>";
                    echo '<td>
                            <form method="post" action="tableau_de_bord.php">
                                <input type="hidden" name="modifier_produit_id" value="' . $row['id'] . '">
                                <button type="submit" name="modifier_produit_action" class="modify">Modifier</button>
                            </form>
                            <form method="post" action="tableau_de_bord.php" onsubmit="return confirmerSuppression();">
                                <input type="hidden" name="supprimer_produit_id" value="' . $row['id'] . '">
                                <button type="submit" name="supprimer_produit_action" class="delete">Supprimer</button>
                            </form>
                        </td>';
                    echo "</tr>";
                }
            } else {
                echo "Erreur lors de la récupération des produits : " . $mysqli->error;
            }
            ?>
        </table>

        <h3>Demandes d'Approbation</h3>
        <table>
            <tr>
                <th>ID Utilisateur</th>
                <th>Nom d'Utilisateur</th>
                <th>Actions</th>
            </tr>

            <?php
            $query_demandes = "SELECT id, nom_utilisateur FROM utilisateurs WHERE demande_approbation = 0";
            $result_demandes = $mysqli->query($query_demandes);

            if ($result_demandes) {
                while ($row_demande = $result_demandes->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row_demande['id'] . "</td>";
                    echo "<td>" . $row_demande['nom_utilisateur'] . "</td>";
                    echo '<td>
                            <form method="post" action="tableau_de_bord.php">
                                <input type="hidden" name="utilisateur_id" value="' . $row_demande['id'] . '">
                                <button type="submit" name="approuver_demande" class="approve">Approuver</button>
                            </form>
                            <form method="post" action="tableau_de_bord.php" onsubmit="return confirmerSuppression();">
                                <input type="hidden" name="supprimer_demande_id" value="' . $row_demande['id'] . '">
                                <button type="submit" name="supprimer_demande_action" class="delete">Supprimer</button>
                            </form>
                        </td>';
                    echo "</tr>";
                }
            } else {
                echo "Erreur lors de la récupération des demandes d'approbation : " . $mysqli->error;
            }
            ?>
        </table>

        <p class="message"><?php echo $message; ?></p>
        <p class="error"><?php echo $erreur; ?></p>
    </div>
</body>
</html>
