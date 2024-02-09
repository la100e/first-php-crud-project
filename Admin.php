<?php
    session_start();
    
    if (!isset($_SESSION['LoggedInAdmin']) || $_SESSION['LoggedInAdmin']==false) {
        header('Location: AdminLogin.php');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <div class="header">
        <?php include 'header.php';?>
        <h1>Gestion des articles</h1>
    </div>
    <div class="header">
    <a class="btnlink" href="Gestion_clients.php">Gestion des clients</a>
    <a class="btnlink" href="Gestion_articles.php">Gestion des articles</a>
    <a class="btnlink" href="Commandes.php">Consultation des commandes</a>
    </div>
    
</body>
</html>