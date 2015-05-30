<?php session_start();
$login=$_SESSION['login'];
?>
<html>
<head>
    <title>NimpStore - Mes Applications</title>
   <meta charset='utf-8'>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/css.css">
</head>
<body>
<?php include("navbar.php");
      include("idConnex.php");
    require("class/class.php");
?>

<h1>Vos applications <?php echo $login; ?></h1>

<?php 
$querystring="SELECT * FROM ((client c INNER JOIN produit_achete pa ON c.login=pa.proprietaire)R1
                            INNER JOIN v_application va ON R1.produit=va.titre) R2
                            INNER JOIN editeur e ON e.id = R2.editeur
                            WHERE R2.login='$login'"; //Requete du turfu by LeLu #checkdisout
$query=pg_query($querystring);
$res=pg_fetch_array($query);

if (is_null($res['titre'])){
    echo "<p> Vous ne possédez pas encore d'application! Trouvez dès maintenant celle de vos rêves grâce à l'outil recherche !</p>";
}else{
    while(!is_null($res['titre'])){
        $app = new application($res['titre'],$res['nom'],$res['prix']);
        $app->afficher();
        $res = pg_fetch_array($query);
    }
}
?>

    
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script src="js/jquery.localscroll.js"></script>
<script src="js/jquery.scrollTo.js"></script>
<script src="js/bootstrap.min.js"></script>  
</body>
</html>