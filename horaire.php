<?php
require_once 'inc/init.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Horaires d'ouverture</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<?php include_once 'inc/head.php'; ?>

<body>
<div class="main-container">
    <div class="custom-section">
        <h1 class="custom-section-heading">Horaires d'ouverture</h1>
        <div class="custom-section-cards">
            <?php
    $horaires = array(
        "Lundi" => "7h00 - 20h00",
        "Mardi" => "7h00 - 20h00",
        "Mercredi" => "7h00 - 20h00",
        "Jeudi" => "7h00 - 20h00",
        "Vendredi" => "7h00 - 20h00",
        "Samedi" => "7h00 - 20h00",
        "Dimanche" => "Fermé"
    );

    echo "<ul>";
    foreach ($horaires as $jour => $horaire) {
        echo "<li class='custom-horaire'>$jour : $horaire</li>";
    }
    echo "</ul>";
    ?>
            </div>
        </div>
    </div>
</div>

    <?php include_once 'inc/foot.php'; ?>

</body>
</html>
