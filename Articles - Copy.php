<?php
    session_start();
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Des Articles</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="header">
        <?php include 'header.php';?>
        <h1>List Des Articles</h1>
    </div>
    <form method="post">
        <select name="list" id="list">
            <option value="">----</option>
            <?php
                include 'connexion.php';
                $cat = $connexion->prepare('select distinct categorie from article');
                $cat->execute();
                $categories = $cat->fetchAll(PDO::FETCH_COLUMN);
                foreach ($categories as $element) {
                    $selected = $_POST['list'] == $element ? 'selected' : '';
                    echo '<option value="'.$element.'" '.$selected.'>'.$element.'</option>';
                }
            ?>
        </select>
        <input type="submit" value="Chercher">
    </form>
    <?php
        function AfficherArticles($articles) {
            echo "<table><tr><th>Num_Article</th><th>Designation</th><th>Prix Unitaire</th><th>Categorie</th><th colspan='2' ></th></tr>";
            foreach ($articles as $element) {
                echo "<tr><td>{$element['num_article']}</td><td>{$element['designation']}</td><td>{$element['pu']}</td><td>{$element['categorie']}</td><td><a href='Modifier.php?id={$element['num_article']}'>Modifier</a></td><td><a href='Supprimer.php?id={$element['num_article']}'>Supprimer</a></td></tr>";
            }
            echo "</table>";
        }
        //if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $sqlquery='select * from article';
            if(isset($_POST['list']) && $_POST['list']!='') $sqlquery.=' where categorie = ?';
            $select = $connexion->prepare( $sqlquery);
           
           if(isset($_POST['list'])  && $_POST['list']!='') $select->execute([$_POST['list']]);
           else $select->execute();
            $articles = $select->fetchAll(PDO::FETCH_ASSOC);
            AfficherArticles($articles);
        //}
    ?>
</body>
</html>