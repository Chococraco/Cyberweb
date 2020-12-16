<?php
include 'db_connection.php';

//Auth
if(isset($_POST['login']) && isset($_POST['password'])) {

    //LOG
    $text = '[' .date('l jS \of F Y h:i:s A'). '] ' ."Tentative de connexion : " . $_SERVER['REMOTE_ADDR'];
    $myfile = file_put_contents('logs.txt', $text.PHP_EOL , FILE_APPEND | LOCK_EX);

// Eléments d'authentification LDAP
    $ldaprdn = "uid=".$_POST['login'].",cn=users,cn=accounts,dc=alphapar,dc=mylocal";     // DN ou RDN LDAP
    $ldappass = $_POST['password'];  // Mot de passe associé

// Connexion au serveur LDAP
    $ldapconn = ldap_connect("ldap://ad.alphapar.mylocal")
    or die("Impossible de se connecter au serveur LDAP.");

    if ($ldapconn) {

        // Connexion au serveur LDAP
        $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);

        // Vérification de l'authentification
        if ($ldapbind) {
            //Connexion réussie
            session_start();
            $_SESSION['auth'] = true;
            $_SESSION['user'] = $_POST['login'];
            //LOG
            $text = '[' .date('l jS \of F Y h:i:s A'). '] ' ."Connexion réussie de l'utilisateur " . $_POST['login'] . ' à ladresse suivante : ' . $_SERVER['REMOTE_ADDR'] ;
            $myfile = file_put_contents('logs.txt', $text.PHP_EOL , FILE_APPEND | LOCK_EX);
            echo('true');
            exit();
        } else {
            //LOG
            $text = '[' .date('l jS \of F Y h:i:s A'). '] ' ."Echec de connexion de l'utilisateur " . $_POST['login'] . ' à ladresse suivante : ' . $_SERVER['REMOTE_ADDR'] ;
            $myfile = file_put_contents('logs.txt', $text.PHP_EOL , FILE_APPEND | LOCK_EX);
            //Echec
            echo('false');
            exit();
        }

    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>

    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- SCRIPT BOOTSTRAP JQUERRY -->
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="../css/style.css">

    <!-- SCRIPT -->
    <script src="../js/util.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="login-label">Connexion</div>
    </div>
    <div class="row">
        <div class="login-box">
            <input id="login" class="login-input" placeholder="Identifiant">
            <input id="password" class="login-input" placeholder="Mot de passe" type="password">
            <button class="login-button" id="login-button" onclick="login()">CONNEXION</button>
        </div>
    </div>
</div>
</body>
</html>