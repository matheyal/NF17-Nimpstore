<?php //Récupération des attributs de redirection afin de customiser la page

session_start(); //Lancement de la session php

if (isset($_SESSION['login'])){ //On vérifie qu'un user est loggé ou pas, si oui, on récupère la valeur du login
    $login=$_SESSION['login'];
    $admin=$_SESSION['admin'] ;
}
else{
    session_destroy();
    $login=NULL;
}

//          ---------------------------------------

include("idConnex.php");
require("class/class.php");

?>

<head>
<title>NimpStore</title>
<meta charset='utf-8'>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-theme.min.css">
<link rel="stylesheet" href="css/css.css">
</head>
<body>
<?php include("navbar.php"); ?>