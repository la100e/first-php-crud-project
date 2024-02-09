<?php
    session_start();
    if (!isset($_SESSION['LoggedIn']) || $_SESSION['LoggedIn']==false) {
        header('Location: authentification.php');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .msg {
            color: red;
        }
    </style>
</head>
<body>
    <script src="jquery-3.7.0.js"></script>
<div class="header">
        <?php include 'header.php';?>
        <h1>Client</h1>
    </div>
        <?php
            include 'connexion.php';

            $select = $connexion->prepare('select * from client where num_client = ?');
            $select->execute([$_SESSION['num']]);

            $client = $select->fetchAll(PDO::FETCH_ASSOC);
            //var_dump($client);
        ?>
            <form method="post" id="myform">
        <table>
            <tr>
                <td>Nom</td>
                <td><input type="text" name="nom" id="nom" value="<?php echo isset($_POST['nom'])? $_POST['nom'] : $client[0]['nom'] ?>"></td>
                <td class="msg" id="nommsg">*</td>
            </tr>
            <tr>
                <td>Adresse</td>
                <td><input type="text" name="ad" id="ad" value="<?php echo isset($_POST['ad'])? $_POST['ad'] : $client[0]['adresse'] ?>"></td>
                <td class="msg" id="admsg">*</td>
            </tr>
            <tr>
                <td>Ville</td>
                <td>
                    <select name="ville" id="ville">
                        <option value=""></option>
                        <?php
                        $villes = ['villex','villey','villez'];
                            foreach ($villes as $ville) {
                                $selected = ((isset($_POST['ville']) && $_POST['ville'] == $ville) || ($client[0]['ville'] == $ville)) ? 'selected' : '';
                                echo '<option value="'.$ville.'" '.$selected.'>'.$ville.'</option>';
                            }
                        ?>
                    </select>
                </td>
                <td class="msg" id="villemsg">*</td>
            </tr>
            <tr>
                <td>Telephone</td>
                <td><input type="text" name="tel" id="tel" value="<?php echo isset($_POST['tel'])? $_POST['tel'] : $client[0]['tel'] ?>"></td>
                <td class="msg" id="telmsg">*</td>
            </tr>
            <tr>
                <td>Login</td>
                <td><input type="text" name="login" id="login" value="<?php echo isset($_POST['login'])? $_POST['login'] : $client[0]['login'] ?>"></td>
                <td class="msg" id="loginmsg">*</td>
            </tr>
            <tr>
                <td>Mot de passe</td>
                <td><input type="password" name="password" id="password"  value="<?php echo isset($_POST['password'])? $_POST['password'] : $client[0]['pass'] ?>"></td>
                <td class="msg" id="passwordmsg">*</td>
            </tr>
        </table>
        <input type="submit" value="Modifier">
    </form>
    <script>
        $('#myform').submit((event) => {
            var bool = true;
            let ids = ['nom', 'ad', 'ville', 'tel', 'login', 'password'];
            ids.forEach(id => {
                $('#'+id).val() == '' ? (bool = false, $(`#${id}msg`).text(` * Champ de ${id} est vide`)) : $(`#${id}msg`).text(``);
            });
            ! /^(?=.*[A-Za-z])(?=.*\d).+$/.test($('#password').val()) ? (bool = false, $('#passwordmsg').text(` * Champ de mot de passe est invalide`)) : $('#passwordmsg').text(``);
            ! /^06[0-9]{8}$/.test($('#tel').val()) ? (bool = false, $('#telmsg').text(` * Champ de telephone est invalide`)) : $('#passwordmsg').text(``);
            
            if (!bool)  
                event.preventDefault();
        })
    </script>
    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            include 'connexion.php';
            $update = $connexion->prepare('update client set nom=?,adresse=?,ville=?,tel=?,login=?,pass=? where num_client=?');
            $update->execute([$_POST['nom'], $_POST['ad'], $_POST['ville'], $_POST['tel'], $_POST['login'], $_POST['password'], $_SESSION['num']]);
        }
    ?>
</body>
</html>