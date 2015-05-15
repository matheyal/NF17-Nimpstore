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
</head>
<body >
<?php // Personalisation de la page index si l'utilisateur est loggé
echo("<h1 align='center'> Bienvenue sur le NimpStore $login ! </h1>");
?>
<p> Vous trouverez toute sorte d'application utile au quotidient ici !<p>
<div name='presentation'>
<p><font color='red'> Faire le défilé d'app</font></p>
</div>
<div name='recherche'>
<p> Recherchez l'application de vos rêves ici !
<form Method='GET' action='result.php'> <p>Nom de l'App : <input type='text' name='nom'> <br/> <input value='Rechercher' type='submit'</p> </form>
</div>

<?php //Affichage du module HTML de log si l'utilisateur n'est pas loggé
if (is_null($login))
    echo("
    <div name='log'>
    <form Method='POST' action='connection.php'> <p>
    Login : <input type='text' name='login'> <br/>
    Mot de passe : <input type='password' name='pass'> <br/>
    <input value='Connection' type='submit'> </p> </form>
    <p> Pas encore inscrit ? <a href='inscription.php'>C'est par ici</a>
    ");
else {
    echo("
    <form action='index.php'> <input type='submit' value='Déconnection'>
    ");
}
if ($err == 1) echo("<p><font color='red'>Erreur de log</font></p>"); //Petite info au cas ou
?>

</body>
</html>