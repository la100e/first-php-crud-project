<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des clients</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <script src="jquery-3.7.0.js"></script>
    <?php
        if (!isset($_SESSION['LoggedInAdmin']) || $_SESSION['LoggedInAdmin']==false) {
            header('Location: AdminLogin.php');
            exit;
        }
    ?>
    <div class="header">
        <h1>Gestion des clients</h1>
        <?php include 'header.php';?>
    </div>
    <form method="get" id="myform">
        <input type="number" name="num" id="num" placeholder="Numero du client"><span id="nummsg"></span><br>
        <input type="submit" value="Chercher">
        <a href="AllClients.php" class="btnlink" target="_blank">Tous les clients</a>
    </form>
    <script>
        $('#myform').submit((event) => {
            let bool = true;
            $('#num').val() == '' ? (bool = false, $('#nummsg').text('* Numero Invalide !')) : $('#nummsg').text('');
            if (! bool)
                event.preventDefault();
        })
    </script>
    <?php
        include 'connexion.php';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $req = $connexion->prepare('select * from client where num_client = ?');
            $req->execute([$_POST['num']]);

            if ($req->rowCount()==0)
                echo "<div>Introuvable !</div>";
            else{
                $client = $req->fetchAll(PDO::FETCH_ASSOC);
                echo "<table><tr><th>Num_Client</th><th>Nom</th><th>Adresse</th><th>Ville</th><th>Telephone</th><th>Login</th><th>Mot de passe</th></tr>";
                echo "<tr><td>".$client[0]['num_client']."</td><td>".$client[0]['nom']."</td><td>".$client[0]['adresse']."</td><td>".$client[0]['ville']."</td><td>".$client[0]['tel']."</td><td>".$client[0]['login']."</td><td>".$client[0]['pass']."</td></tr>";
                echo "</table>";
            }
        }
    ?>
</body>
</html>