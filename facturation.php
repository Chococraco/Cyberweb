<?php
session_start();
if (isset($_SESSION['auth'])){

}else{
    //LOG
    $text = '[' .date('l jS \of F Y h:i:s A'). '] ' ."Demande accès facturation par utilisateur inconnue" . ' à ladresse suivante : ' . $_SERVER['REMOTE_ADDR'];
    $myfile = file_put_contents('logs.txt', $text.PHP_EOL , FILE_APPEND | LOCK_EX);
    header('Location: login.php');
}
include 'db_connection.php';

if(isset($_POST['nom'])){
    //LOG
    $text = '[' .date('l jS \of F Y h:i:s A'). '] ' ."Enregistrement facture par " . $_SESSION['user']  . ' à ladresse suivante : ' . $_SERVER['REMOTE_ADDR'];
    $myfile = file_put_contents('logs.txt', $text.PHP_EOL , FILE_APPEND | LOCK_EX);


    $sql = 'INSERT INTO facture (id_client, id_produit, nom, prix, date) VALUES ('.$_POST['client'].','.$_POST['produit'].',"'.$_POST['nom'].'","'.$_POST['prix'].'");';
    $conn->query('INSERT INTO facture (id_client, id_produit, nom, prix, date) VALUES ('.$_POST['client'].','.$_POST['produit'].',"'.$_POST['nom'].'","'.$_POST['prix'].'", "'.$_POST['date'].'");');
    echo($sql);
    return;
}











$produit = $conn->query("SELECT * FROM produit");
$client = $conn->query("SELECT * FROM client");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Facturation</title>

    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- SCRIPT BOOTSTRAP JQUERRY -->
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/menu.css">

    <!-- SCRIPT -->
    <script src="../js/util.js"></script>
</head>
<body>
<div id='cssmenu'>
    <ul>
        <li><a href='client.php'>Client</a></li>
        <li><a href='plan.php'>Plan</a></li>
        <li class='active'><a href='facturation.php'>Facturation</a></li>
        <li id="logout"><a href='logout.php'>Deconnexion</a></li>
    </ul>
</div>
<div class="container">
    <div class="row">
        <div class="title">Facturation :</div>
    </div>
    <div class="row">
        <div class="col-4">
            <select id="produit-liste" class="input-facturation" placeholder="Produit">
                <?php
                while($obj = $produit->fetch_object()){
                    echo('<option value ="'.$obj->id.'">'.$obj->nom.'</option>');
                }
                ?>
            </select>
        </div>
        <div class="col-4">
            <select id="client-liste" class="input-facturation" placeholder="Client">
                <?php
                while($obj = $client->fetch_object()){
                    echo('<option value ="'.$obj->id.'">'.$obj->nom.'</option>');
                }
                ?>
            </select>
        </div>
        <div class="col-4"><input id="date" type="date" class="input-facturation" placeholder="Date"></div>
    </div>
    <div class="row">
        <input id="nom" class="input-large2-facturation" placeholder="Nom de la facture...">
    </div>
    <div class="row">
        <textarea id="detail" class="input-large-facturation" placeholder="Détail de la facture..."></textarea>
    </div>
    <div class="row">
        <input id="prix" class="input-large2-facturation" placeholder="Prix...">
    </div>
    <div class="row">
        <button id="facture-button" class="facture-button" onclick="facture()">FACTURER</button>
    </div>
</div>
</body>
</html>
