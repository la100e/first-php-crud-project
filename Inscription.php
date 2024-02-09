<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .msg {
            color: red;
        }
    </style>
</head>
<body>
<div class="header">
        <?php include 'header.php';?>
        <h1>Inscription</h1>
    </div>
    <script src="jquery-3.7.0.js"></script>
    <form method="post" id="myform">
        <table>
            <tr>
                <td>Nom</td>
                <td><input type="text" name="nom" id="nom"></td>
                <td class="msg" id="nommsg">*</td>
            </tr>
            <tr>
                <td>Prenom</td>
                <td><input type="text" name="prenom" id="prenom"></td>
                <td class="msg" id="prenommsg"></td>
            </tr>
            <tr>
                <td>Adresse</td>
                <td><input type="text" name="ad" id="ad"></td>
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
                                $selected = (isset($_POST['ville']) && $_POST['ville'] == $ville) ? 'selected' : '';
                                echo '<option value="'.$ville.'" '.$selected.'>'.$ville.'</option>';
                            }
                        ?>
                    </select>
                </td>
                <td class="msg" id="villemsg">*</td>
            </tr>
            <tr>
                <td>Telephone</td>
                <td><input type="text" name="tel" id="tel"></td>
                <td class="msg" id="telmsg">*</td>
            </tr>
            <tr>
                <td>Login</td>
                <td><input type="text" name="login" id="login"></td>
                <td class="msg" id="loginmsg">*</td>
            </tr>
            <tr>
                <td>Mot de passe</td>
                <td><input type="password" name="password" id="password"></td>
                <td class="msg" id="passwordmsg">*</td>
            </tr>
        </table>
        <input type="submit" value="S'inscrire">
    </form>
    <script>
        $('#myform').submit((event) => {
            var bool = true;
            let ids = ['nom', 'ad', 'ville', 'tel', 'login', 'password'];
            ids.forEach(id => {
                $('#'+id).val() == '' ? (bool = false, $('#'+id+'msg').text(` * Champ de ${id} est vide`)) : $('#'+id+'msg').text(``);
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
            $insert = $connexion->prepare('insert into client (nom,adresse,ville,tel,login,pass) values (?,?,?,?,?,?)');
            $insert->execute([$_POST['nom'], $_POST['ad'], $_POST['ville'], $_POST['tel'], $_POST['login'], $_POST['password']]);
        }
    ?>
</body>
</html>

