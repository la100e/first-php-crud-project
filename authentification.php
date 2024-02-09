<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <script src="jquery-3.7.0.js"></script>
    <div class="header">
        <?php include 'header.php';?>
        <h1>Client Authentification</h1>
    </div>
    <form method="post" id="myform">
        <table>
            <tr>
                <td class="first">Login : </td>
                <td><input type="text" id="login" name="login" placeholder="LOGIN"></td>
                <td class="msg" id="user"></td>
            </tr>
            <tr>
                <td class="first">Mot de passe : </td>
                <td><input type="password" name="password" id="password" placeholder="********"></td>
                <td class="msg" id="pw"></td>
            </tr>
        </table>
        <input type="submit" value="Connexion">
    </form>
    <script>
        $('#myform').submit((event) => {
            let bool = true;
            $('#login').val() == '' ? (bool = false, $('#user').text('* Login Invalide !')) : $('#user').text('');
            $('#password').val() == '' ? (bool = false, $('#pw').text('* Mot de passe Invalide !')) : $('#pw').text('');
            if (! bool)
                event.preventDefault();
        })
    </script>
    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            include 'connexion.php';

            $req = $connexion->prepare('select * from client where login=? and pass=?');
            $req->execute([$_POST['login'], $_POST['password']]);

            if ($req->rowCount() == 0) {
                echo '<div class="F">Sign Up Please</div>';
                header('Location:Inscription.php');
            }
            else {
                session_start();
                $user = $req->fetchAll(PDO::FETCH_ASSOC);
                $_SESSION['num'] = $user[0]['num_client'];
                $_SESSION['LoggedIn'] = true;
                header('Location: Client.php');
            }
        }
    ?>
</body>
</html>