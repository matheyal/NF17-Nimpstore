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

<h1>Vos Terminaux <?php echo $login; ?></h1>

<?php 
$querystring="SELECT * FROM client c INNER JOIN terminal t ON c.login=t.proprietaire
                WHERE c.login='$login'";//Requete du turfu by LeLu #checkdisout
$query=pg_query($querystring);
$res=pg_fetch_array($query);

if (is_null($res['modele'])){
echo "<p>Vous n'avez pas encore renseigné d'informations concernant vos appareils! Vous pourrez bientôt en ajouter autrement qu'en demandant à Alexis Mathey de modifier les tables ! #comingsoon</p>";
}else{
    while($res){
        echo "<p>Modèle : ".$res['modele']."</p>";
        echo "<p>N° Série : ".$res['numero_serie']."</p>";
        echo "</br>";
    }
}
?>

    
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script src="js/jquery.localscroll.js"></script>
<script src="js/jquery.scrollTo.js"></script>
<script src="js/bootstrap.min.js"></script>  
</body>
</html>