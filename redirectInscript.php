<?php

include("f.php");
include("idConnex.php");
$login = $_POST['login']; // Récupération des variables necessaires pour la fonction d'inscription
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$pass = $_POST['pass'];

if (0 == ($test = fSignIn($login,$nom,$prenom,$pass,$idConnex))) { // Cas d'inscription réussit, redirection vers l'index loggé
    echo("
            <html>
            <body>
            <h2><font color='red'>Merci pour votre inscription !</font></h2>
            <p>Vous allez etre redirige vers la page d'accueil.</p>

    ");
    session_start();
    $_SESSION['login'] = $login;
    header('refresh:2;index.php?logged=1'); // Redirection vers l'index
    echo("<p> Sinon clickez <a href='index.php?logged=1'>ici</a></p>");
}
else
    header('Location: inscription.php?err=1'); // Redirection en cas d'echec
?>
</body>
</html>