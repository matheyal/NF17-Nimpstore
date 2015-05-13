<html>
<head>
   <title>NimpStore</title>
   <meta charset='utf-8'>
</head>
<body >
<h1> Bienvenue sur le NimpStore ! </h1>
<p> Vous trouverez toute sorte d'application utile au quotidient ici !<p>
<div name='presentation'>
<p><font color='red'> Faire le défilé d'app</font></p>
</div>
<div name='recherche'>
<p> Recherchez l'application de vos rêves ici !
<form Method='GET' action='result.php'> <p>Nom de l'App : <input type='text' name='nom'> <br/> <input value='Rechercher' type='submit'</p> </form>
</div>

<?php
if (1)//if not loggedin
    echo("
    <div name='log'>
    <form Method='POST' action='connection.php'> <p>
    Login : <input type='text' name='login'> <br/>
    Mot de passe : <input type='password' name='pass'> <br/>
    <input value='Connection' type='submit'> </p> </form>
    <p> Pas encore inscrit ? <a href='inscription.php'>C'est par ici</a>
    ");
else
    echo("<p>Welcome blablabla !</p>");

?>

</body>
</html>