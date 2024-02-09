<?php
$isadmin=false;
$isclient=false;
        if (isset($_SESSION['LoggedInAdmin']) && $_SESSION['LoggedInAdmin']!=false) $isadmin=true;
        if (isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn']!=false) $isclient=true;
?>
<ul class="nav">
    
    <li><a href="http://mysites/Project/Articles_Cards.php">Articles [cartes]</a></li>
    <?php
     if($isadmin) {
        echo '<li><a href="http://mysites/Project/Articles.php">List Des Articles</a></li>';
        echo '<li><a href="http://mysites/Project/Admin.php">Administration</a></li>';
        echo '<li><a href="http://mysites/Project/Gestion_articles.php">Gestion Des Articles</a></li>';
        echo '<li><a href="http://mysites/Project/Gestion_clients.php">Gestion Des Clients</a></li>';
        echo '<li><a href="http://mysites/Project/commandes.php">Liste Des Commandes</a></li>';
    }
     if(!$isadmin && !$isclient) {
        echo '<li><a href="http://mysites/Project/Inscription.php">Inscription</a></li>';
        echo '<li><a href="http://mysites/Project/authentification.php">Client Auth</a></li>';
        echo '<li><a href="http://mysites/Project/AdminLogin.php">Admin Auth</a></li>';
    
    }else{
        echo '<li><a href="http://mysites/Project/Deconnexion.php">Deconnexion</a></li>';
    }
    ?>
</ul>