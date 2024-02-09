<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commandes</title>
    <script src="jquery-3.7.0.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="header">
        <?php include 'header.php';?>
        <h1>Liste des commandes</h1>
    </div>
    <?php
        //session_start();
        if (!isset($_SESSION['LoggedInAdmin']) || $_SESSION['LoggedInAdmin']==false) {
            header('Location: AdminLogin.php');
            exit;
        }
         include 'connexion.php';
        
        $sqlcmd='select c.num_cmd,c.date_cmd,cl.nom from commande as c inner join client as cl on cl.num_client=c.num_client';
        if(isset($_GET['stype']) && $_GET['stype']!=''){
            if($_GET['stype']=='cmdnum'){
                $sqlcmd.=' where num_cmd='.$_GET['cmdnum'];
            }elseif($_GET['stype']=='cmddate'){
                $sqlcmd.=" where date_cmd='".$_GET['cmddate1']."'";
            }elseif($_GET['stype']=='daterange'){
                $sqlcmd.=" where date_cmd>='".$_GET['cmddate1']."' and date_cmd<='".$_GET['cmddate2']."'";
            }
            
        }
        $sqlcmd.=" order by c.num_cmd";
        $cmd = $connexion->prepare( $sqlcmd);
        $cmd->execute();
        $commandes = $cmd->fetchAll(PDO::FETCH_ASSOC);
        $stype=isset($_GET['stype'])?$_GET['stype']:'';
        ?>
        <form method="GET">
            Recherché par: 
            <select name="stype" id="cmdstype">
                <option value="">---</option>
                <option value="cmdnum" <?php if($stype && $stype=='cmdnum') echo 'selected'; ?>>Numéro de commande</option>
                <option value="cmddate" <?php if($stype && $stype=='cmddate') echo 'selected'; ?>>Date de commande</option>
                <option value="daterange" <?php if($stype && $stype=='daterange') echo 'selected'; ?>>Entre deux dates</option>
            </select>
            
            <input required value="<?=isset($_GET['cmdnum'])?$_GET['cmdnum']:''?>" type="number" name="cmdnum" class="st st-cmdnum" style="<?php if(!$stype || $stype!='cmdnum') echo 'display:none;'; ?>">
            <input required value="<?=isset($_GET['cmddate1'])?$_GET['cmddate1']:''?>"  type="date" name="cmddate1" class="st st-cmddate st-daterange"  style="<?php if(!$stype || $stype=='cmdnum') echo 'display:none;'; ?>">
            <input required value="<?=isset($_GET['cmddate2'])?$_GET['cmddate2']:''?>"  type="date" name="cmddate2" class="st  st-daterange"  style="<?php if(!$stype || $stype!='daterange') echo 'display:none;'; ?>">
            <input type="submit" value="Rechercher">
        </form>
        <script>
                $('#cmdstype').on('change', function() {
                $('.st').hide();
                $('.st').prop('disabled', true);
                $('.st-'+this.value).show();
                $('.st-'+this.value).prop('disabled', false);
                });
                $('#cmdstype').change();
            </script>
        <?php
        echo "<table><tr><th>Numéro de commande</th><th>Date de commande</th><th>Nom de Client</th></tr>";
        foreach ($commandes as $element) {
            echo "<tr><td>{$element['num_cmd']}</td><td>{$element['date_cmd']}</td><td>{$element['nom']}</td></tr>";
        }
    ?>
</body>
</html>