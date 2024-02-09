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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BD</title>
    <script src="jquery-3.7.0.js"></script>
    <link rel="stylesheet" href="bootstrap-5.2.3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <h1>Gestion des articles</h1>
        <?php include 'header.php';?>
    </div>
    <form method="post" id="myform" enctype="multipart/form-data">
        <table>
            <tr>
                <td class="first">num_article : </td>
                <td><input type="number" name="num_article" id="num_article" value="<?php echo isset($_GET['id'])? $_GET['id'] : "" ?>"></td>
                <td id="num_articlemsg" class="msg"></td>
            </tr>
            <?php
                //if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['myaction']=='Rechercher'){
                    include "connexion.php";
                    $selectart = $connexion->prepare("select * from article where num_article=?");
                    $selectart->execute([$_GET['id']]);
                    if ($selectart->rowCount()!==0){
                        $infos = $selectart->fetchAll(PDO::FETCH_ASSOC);
                        $designation = $infos[0]['designation'];
                        $pu = $infos[0]['pu'];
                        $categorie = $infos[0]['categorie'];
                        $path = $infos[0]['path'];
                        // echo ("<script>
                        //     document.getElementById('num_article').value = {$_GET['id']};
                        // </script>");
                    }
                //}
                ?>
            <tr>
                <td>Image</td>
                <td colspan="2"><img src="/imgs/<?php echo isset($path)? $path : "" ?>"></td>
            </tr>
            <tr>
                <td>Put Image</td>
                <td><input type="file" name="img_article" id="img_article" accept="image/*"></td>
                <td></td>
            </tr>
            <tr>
                <td class="first">designation : </td>
                <td><input type="text" name="designation" id="designation" value="<?php echo isset($designation)? $designation : "" ?>"></td>
                <td id="designationmsg" class="msg"></td>
            </tr>
            <tr>
                <td class="first">pu : </td>
                <td><input type="number" name="pu" id="pu" value="<?php echo isset($pu)? $pu : "" ?>"></td>
                <td id="pumsg" class="msg"></td>
            </tr>
            <tr>
                <td class="first">Categorie : </td>
                <td>
                    <select name="categorie" id="categorie">
                        <option value="">------</option>
                        <?php
                            include 'connexion.php';
                            $req = $connexion->prepare("select distinct categorie from article");
                            $req->execute();
                            $categorie = $req->fetchAll(PDO::FETCH_COLUMN);
                            var_dump($categorie);
                            foreach ($categorie as $num) {
                                $selected = (isset($categorie) && $categorie == $num) ? "selected" : "";
                                echo "<option value='$num' $selected>$num</option>";
                            }
                        ?>
                    </select>
                </td>
                <td id="categoriesmsg" class="msg"></td>
            </tr>
        </table>
        <div id="buttons">
            <input type="submit" value="Enregistrer" name="Enregistrer" id="Enregistrer">
            <input type="reset" value="Annuler" name="annuler" id="annuler">
        </div>
    </form><br><br><br>
    <script>
        $('input[type="hidden"]').remove();
        document.addEventListener('DOMContentLoaded', function() {
        var submitButtons = document.querySelectorAll('input[type="submit"]');

        submitButtons.forEach(function(button) {
            button.addEventListener('click', function(event) {
            var buttonValue = button.value;
            sessionStorage.setItem('myaction', buttonValue);
            });
        });

        var form = document.getElementById('myform');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            var myaction = sessionStorage.getItem('myaction');

            // Create a hidden input field
            var hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'myaction'; // Set the name for identification on the server-side
            hiddenInput.value = myaction;

            // Append the hidden input to the form
            form.appendChild(hiddenInput);

            // Manually submit the form
            switch (myaction) {

                case "Enregistrer":
                    let bool = true;
                    let ids = ["designation", "pu", "categorie"];
                    for (id of ids) {
                        $("#"+id).val() == "" ? (bool = false , $("#"+id+"msg").text(` * Champ de ${id} est invalide !`)) : $("#"+id+"msg").text(``);
                    }
                    if (bool)
                        form.submit();
                    break;
        
                default:
                    break;
            }
        });
        });
        $('#myform').on('reset', function(){
        $('.msg').text("");
        $('.hide1').remove();
        $('.hide2').remove();});
    </script>

    
    <?php
    //var_dump($_GET);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            include 'connexion.php';
            switch ($_POST['myaction']) {

                // AJOUTER -->
                // case 'Ajouter':

                //     $fileTmpPath = $_FILES['img_article']['tmp_name'];
                //     $fileName = $_FILES['img_article']['name'];
                //     $uploadFileDir = './imgs/';
                //     $dest_path = $uploadFileDir . $fileName;
                //     if(move_uploaded_file($fileTmpPath, $dest_path))
                //     {
                //     $message ='File is successfully uploaded.';
                //     }
                    
                //         $insertart = $connexion->prepare("insert into article values (null, ?, ?, ?,?)");
                //         if ($insertart->execute([$_POST['designation'], $_POST['pu'], $_POST['categorie'],$fileName]))
                //             echo("Article bien ajoute");
                //     else
                //         echo("Article deja existe");
                //     break;

                // Enregistrer -->
                case 'Enregistrer':
                    $fileTmpPath = $_FILES['img_article']['tmp_name'];
                    $fileName = $_FILES['img_article']['name'];
                    $uploadFileDir = './imgs/';
                    $dest_path = $uploadFileDir . $fileName;
                    move_uploaded_file($fileTmpPath, $dest_path);
                    $selectart = $connexion->prepare("select * from article where num_article=?");
                    $selectart->execute([$_GET['id']]);
                        $updateart = $connexion->prepare("update article set designation=?, pu=?, categorie=?, path=? where num_article=?");
                        $updateart->execute([$_POST['designation'], $_POST['pu'], $_POST['categorie'],$fileName,$_GET['id']]);
                        unset($_GET['id']);
                        header('Location:Articles.php');
                        exit;
                
                    break;

                // SUPPRIMER -->
                // case 'Supprimer':
                //     $selectart = $connexion->prepare("select * from article where num_article=?");
                //     $selectart->execute([$_POST['num_article']]);
                //     if ($selectart->rowCount()!==0){
                //         $deleteart = $connexion->prepare("delete from article where num_article=?");
                //         if ($deleteart->execute([$_POST['num_article']]))
                //             echo("article bien supprimer");
                //     }
                //     else
                //         echo("article n'xiste pas");
                //     break;

                //AFFICHER -->
                // case 'Afficher':
                //     $selectAll = $connexion->prepare("select * from article");
                //     $selectAll->execute();
                //     if ($selectAll->rowCount()!==0){
                //         $article = $selectAll->fetchAll(PDO::FETCH_ASSOC);
                //         echo "<table class='table table-hover thead-dark'><tr><th>num_article</th><th>designation</th><th>pu</th><th>categorie</th></tr>";
                //         foreach ($article as $key => $value) {
                //             echo "<tr><td>{$value['num_article']}</td><td>{$value['designation']}</td><td>{$value['pu']}</td><td>{$value['categorie']}</td></tr>";
                //         }
                //         echo "</table>";
                //     }
                //     else
                //         echo("0 article !");
                //     break;
                
                default:
                    # code...
                    break;
            }
        }
    ?>
</body>
</html>