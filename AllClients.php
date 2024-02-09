<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Clients</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <script src="jquery-3.7.0.js"></script>
    <div class="header">
        <?php include 'header.php';?>
        <h1>Liste des clients</h1>
    </div>
    <?php
        if (!isset($_SESSION['LoggedInAdmin']) || $_SESSION['LoggedInAdmin']==false) {
            header('Location: AdminLogin.php');
            exit;
        }
        include 'connexion.php';
        $selectAll =$connexion->prepare('select * from client');
        $selectAll->execute();
        $clients = $selectAll->fetchAll(PDO::FETCH_ASSOC);
            echo "<table><tr><th>N</th><th>Nom</th><th>Adresse</th><th>Ville</th><th>Telephone</th><th>Login</th><th>Mot de passe</th></tr>";
            foreach ($clients as $client) {
                echo "<tr><td>{$client['num_client']}</td><td>{$client['nom']}</td><td>{$client['adresse']}</td><td>{$client['ville']}</td><td>{$client['tel']}</td><td>{$client['login']}</td><td>{$client['pass']}</td></tr>";
            }
            echo "</table>";
    ?>
</body>
</html>