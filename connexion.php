<?php
    // function AfficherArticles($articles) {
    //     echo "<table><tr><th>Num_Article</th><th>Designation</th><th>Prix Unitaire</th><th>Categorie</th></tr>";
    //     foreach ($articles as $element) {
    //         echo "<tr><td>{$element['num_article']}</td><td>{$element['designation']}</td><td>{$element['pu']}</td><td>{$element['categorie']}</td></tr>";
    //     }
    //     echo "</table>";
    // }
    // function AfficherClient($client) {
    //     echo "<table><tr><th>Num_Client</th><th>Nom</th><th>Adresse</th><th>Ville</th><th>Telephone</th><th>Login</th><th>Mot de passe</th></tr>";
    //         echo "<tr><td>{$client['num_client']}</td><td>{$client['nom']}</td><td>{$client['adresse']}</td><td>{$client['ville']}</td><td>{$client['tel']}</td><td>{$client['login']}</td><td>{$client['pass']}</td></tr>";
    //     echo "</table>";
    // }
    // function outputMessage($msg, $bool)
    // {
    //     if ($bool)
    //         echo "<div class='hide1'>$msg</div>";
    //     else
    //         echo "<div class='hide2'>$msg</div>";
    // }
    try {
        $connexion = new PDO('mysql:host=localhost;dbname=magasin','root','');
    }catch(Exception $e) {
        echo $e->getMessage();
        exit;
    }
?>