<?php //Récupération des attributs de redirection afin de customiser la page

session_start(); //Lancement de la session php

if (isset($_GET['logged'])) { //On vérifie qu'un user est loggé ou pas, si oui, on récupère la valeur du login
    if (!isset($_SESSION['login'])) die("Tu m'as pris pour un JAMBON ?!?!?"); //Pour les petits malins qui veulent hacker
    $logged = $_GET['logged'];
    $login = $_SESSION['login'];
}
else {
    session_destroy();
    $logged = NULL;
    $login = NULL;
}

if (isset($_GET['err'])) // Gestion des erreurs de log
    $err =  $_GET['err'];
else
    $err = NULL;
?>

<html>
<head>
   <title>NimpStore</title>
   <meta charset='utf-8'>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css"
</head>
<body >
    
    
<?php // Personalisation de la page index si l'utilisateur est loggé
include("navbar.php");
echo("<h1 align='center'> Bienvenue sur le NimpStore $login ! </h1>");
?>
    <p align='center'> Vous trouverez toute sorte d'application utile au quotidient ici !</p>
<div name='presentation'>
<p><font color='red'> Brand new Apps' !</font></p>
<?php // défilé des 5 dernières applications ajoutée => serait plus pertinent de mettre les plus téléchargées quand dispo
include("idConnex.php");

$querystring="SELECT * FROM v_application va INNER JOIN editeur e ON va.editeur=e.id";
$query=pg_query($querystring);

$i=0;
for ($i=0;$i<5;$i++){
    $res=pg_fetch_array($query);
 if (!is_null($res)){
        echo "<p>Nom : ".$res['titre']."</p>";
        echo "<p>Editeur : ".$res['nom']."</p>";
        echo "</br>";
 }
}

?>
</div>

<?php 
if ($err == 1) echo("<p><font color='red'>Erreur de log</font></p>"); //Petite info au cas ou
?>

    
    
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script src="js/jquery.localscroll.js"></script>
<script src="js/jquery.scrollTo.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>