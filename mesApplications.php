<?php session_start();
$login=$_SESSION['login'];
?>
<html>
<head>
    <title>NimpStore - Mes Applications</title>
   <meta charset='utf-8'>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css"
</head>
<body>
<?php include("navbar.php");
      include("idConnex.php");
?>

<h1>Vos applications <?php echo $login; ?></h1>

<?php 
$querystring="SELECT * FROM (client c INNER JOIN produit_achete pa ON c.login=pa.proprietaire)R1
                            INNER JOIN v_application va ON R1.produit=va.titre
                            WHERE R1.login='$login'"; //Requete du turfu by LeLu #checkdisout
$query=pg_query($idConnex,$querystring);
$res=pg_fetch_array($query);

if (is_null($res['titre'])){
    echo "<p> Vous ne possédez pas encore d'application! Trouvez dès maintenant celle de vos rêves grâce à l'outil recherche !</p>";
}else{
    while(!is_null($res['titre'])){
        echo "<p>Nom : ".$res['titre']."</p>";
        echo "<p>Editeur : ".$res['editeur']."</p>";
        echo "</br>";
        $res=pg_fetch_array($query);
    }
}
?>

    
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script src="js/jquery.localscroll.js"></script>
<script src="js/jquery.scrollTo.js"></script>
<script src="js/bootstrap.min.js"></script>  
</body>
</html>