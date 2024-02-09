<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commandes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        if (!isset($_SESSION['LoggedIn']) || $_SESSION['LoggedIn']==false) {
            header('Location: authentification.php');
            exit;
        }
         include 'connexion.php';
        $cmd = $connexion->prepare('select * from commande where num_client = ?');
        $cmd->execute([$_SESSION['num']]);
        $commandes = $cmd->fetchAll(PDO::FETCH_ASSOC);

        echo "<table><tr><th>Num_Commande</th><th>Date_Commande</th><th>Num_Client</th></tr>";
        foreach ($commandes as $element) {
            echo "<tr><td>{$element['num_cmd']}</td><td>{$element['date_cmd']}</td><td>{$element['num_client']}</td></tr>";
        }
    ?>
</body>
</html>