<?php
//define("DB_HOST", "localhost"); // Adresse du serveur MySQL
//define("DB_USER", "id21445716_amine_admin"); // Nom d'utilisateur MySQL
//define("DB_PASS", "31011974@Fa"); // Mot de passe MySQL
//define("DB_NAME", "id21445716_bddcoinchaud"); // Nom de la base de données

//$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

//if ($mysqli->connect_error) {
//    die("Erreur de connexion à la base de données : " . $mysqli->connect_error);
//}

$servername = "localhost";
$username = "root";
$password = "root";
$database = "Bdd-boulangerie";

// Établir la connexion à la base de données
$mysqli = mysqli_connect($servername, $username, $password, $database);

// Vérifier la connexion
if (!$mysqli) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

?>
