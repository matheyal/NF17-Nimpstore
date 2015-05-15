<?php
include("f.php");
include("idConnex.php");
$login=$_POST['login']; // Récupération des variable pour la fonciton de log
$pass=$_POST['pass'];
if (1==fLogin($login,$pass,$idConnex)) {
    session_start();
    $_SESSION['login'] = $login;
    header('Location: index.php?logged=1');
}
/*else if (2==fLogin($login,$pass,$idConnex)  Ne pas oublier de mettre en place une page spécial admin, qui implique une redirection spéciale
    header('Location Page admin');*/
else {
    $err = 1;
    header('Location: index.php?err=' . $err); // Redirection en cas d'erreur de log
}
?>