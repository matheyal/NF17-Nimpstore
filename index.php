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
    
    <!-- NAVBAR -->
    <nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Nimpstore</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      
      <form class="navbar-form navbar-left" role="search" action="result.php">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search" name="recherche">   <!-- RECHERCHE -->
        </div>
        <button type="submit" class="btn btn-default">Rechercher</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <?php
        echo (is_null($login))? '<button type="button" class="btn btn-default navbar-btn"
                                        onclick="self.location.href=\'inscription.php\'">S\'inscrire</button>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Connection<span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
              <form method="post" action="connection.php">
            <li><input type="text" name="login" value="login"></li>
            <li><input type="password" name="pass" value="password"></li>
            <li><input type="submit" name="submitLog" value="Connection" ></li>
                  </form>
          </ul>
        </li>
        ' //DEFINIR ACTION ONCLICK pour le bouton s'inscrire
            // on affiche soit le bouton s'inscrire + connection, soit les options profil selon si l'utilisateur est connecté ou pas
        : //Sinon
        '<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Mettre login ici <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Profil</a></li>
            <li><a href="#">Mes Applications</a></li>
            <li><a href="#">Mes Terminaux</a></li>
            <li><a href="#">Faire un cadeau</a></li>
            <li class="divider"></li>
            <li><a href="#">Déconnection</a></li>
          </ul>
        </li>'
            ?>
         
          
          
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
 <!-- FIN DE LA NAVBAR -->
    
<?php // Personalisation de la page index si l'utilisateur est loggé
echo("<h1 align='center'> Bienvenue sur le NimpStore $login ! </h1>");
?>
<p> Vous trouverez toute sorte d'application utile au quotidient ici !<p>
<div name='presentation'>
<p><font color='red'> Faire le défilé d'app</font></p>
</div>

<?php //Affichage du module HTML de log si l'utilisateur n'est pas loggé
/*if (is_null($login))
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
}*/
if ($err == 1) echo("<p><font color='red'>Erreur de log</font></p>"); //Petite info au cas ou
?>

    
    
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="js/jquery.localscroll.js"></script>
<script src="js/jquery.scrollTo.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>