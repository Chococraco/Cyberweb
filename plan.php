<?php
session_start();
if (isset($_SESSION['auth'])){

}else{
    //LOG
    $text = '[' .date('l jS \of F Y h:i:s A'). '] ' ."Demande données plan par utilisateur inconnue" . ' à ladresse suivante : ' . $_SERVER['REMOTE_ADDR'] ;
    $myfile = file_put_contents('logs.txt', $text.PHP_EOL , FILE_APPEND | LOCK_EX);
    header('Location: login.php');
}

//LOG
$text = '[' .date('l jS \of F Y h:i:s A'). '] ' ."Demande données plan par " . $_SESSION['user'] . ' à ladresse suivante : ' . $_SERVER['REMOTE_ADDR'] ;
$myfile = file_put_contents('logs.txt', $text.PHP_EOL , FILE_APPEND | LOCK_EX);


//Chargement des datas
include 'db_connection.php';
$produit = $conn->query("SELECT * FROM produit");


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Plan</title>

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
        <li class='active'><a href='plan.php'>Plan</a></li>
        <li><a href='facturation.php'>Facturation</a></li>
        <li id="logout"><a href='logout.php'>Deconnexion</a></li>
    </ul>
</div>
<div id="plan-page"></div>

<div id="tabplan" class="container">
    <div class="row">
        <div class="title">Plans :</div>
    </div>
    <div class="row">
        <div class="toptab col-1">ID</div>
        <div class="toptab col-3">NOM</div>
        <div class="toptab col-6">DESCRIPTION</div>
        <div class="toptab col-1">PRIX</div>
        <div class="toptab col-1">PDF</div>
    </div>
    <?php
    $i = 1;
    while($obj = $produit->fetch_object()){
        if($i % 2 == 0){$casetab = 'pair';}else{$casetab = 'impair';}
        echo('<div class="row tab '.$casetab.'" onclick="expand('.$i.')"><div class="col-1">'.$obj->id.'</div><div class="col-3">'.$obj->nom.'</div><div class="col-6">Description [...]</div><div class="col-1">'.$obj->prix.'</div><div class="col-1">PDF</div></div>');
        echo('<div id="fact'.$i.'" style="display: none"><div class="row"><div class="sub-toptab col-3">NOM PIECE</div><div class="sub-toptab col-3">NOMBRE</div><div class="sub-toptab col-3">PRIX UNITAIRE</div><div class="sub-toptab col-3">STOCK</div></div>');
        $piece = $conn->query("SELECT piece.nom as nom, piece.stock as stock, forme.nombre as nombre, produit.id as id FROM produit, piece, forme WHERE produit.id = forme.id_produit AND piece.id = forme.id_piece AND produit.id = ".$obj->id.";");
        while($obj2 = $piece->fetch_object()){
            echo('<div class="row sub-tab '.$casetab.'"><div class="col-3">'.$obj2->nom.'</div><div class="col-3">'.$obj2->nombre.'</div><div class="col-3">XX€</div><div class="col-3">'.$obj2->stock.'</div></div>');
        }
        echo('</div>');
        $i++;
    }



    ?>
</div>
</body>
</html>
