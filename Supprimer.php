<?php
    //var_dump($_GET);
    //if (isset($GET['id'])){
        include 'connexion.php';
        $deleteart = $connexion->prepare("delete from article where num_article=?");
        $deleteart->execute([$_GET['id']]);
        //echo 'ok';
        unset($_GET['id']);
        header('Location:Articles.php');
    //}
?>