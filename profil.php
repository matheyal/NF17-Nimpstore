<?php session_start();
$login=$_SESSION['login'];
?>
<html>
<head>
    <title>NimpStore - Profil</title>
   <meta charset='utf-8'>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css"
</head>
<body>
<?php include("navbar.php"); ?>
<h1> Gestion du profil </h1>
<h2> Informations personnelles </h2>
    
<?php
include("idConnex.php");
$querystring="SELECT * FROM client c WHERE c.login='$login'";
$query=pg_query($idConnex,$querystring);
$res=pg_fetch_array($query);

echo "<p> Nom : ".$res['nom']."</p>";
echo "<p> Prenom : ".$res['prenom']."</p>";


?>
    
    
    
    
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script src="js/jquery.localscroll.js"></script>
<script src="js/jquery.scrollTo.js"></script>
<script src="js/bootstrap.min.js"></script>  
</body>
</html>