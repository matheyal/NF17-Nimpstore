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

<h1>Ajouter un terminal</h1>
<p>Remplissez le formulaire ci-dessous pour ajouter un nouveau terminal. Vous pourrez ainsi télécharger et installer vos applications favorites sur celui-ci !</p>
<form method="post" action="mesTerminaux.php">
    <input type="text" name="num_serie" placeholder="N° Serie">
    <select name="modele">
    <?php //options
        $querystring = "SELECT designation FROM modele"; //Query pour prendre les noms des éditeurs
        $query = pg_query($idConnex,$querystring);
        $res = pg_fetch_array($query) OR DIE ("BDD buggée !");

        while(!is_null($res['designation'])) { //Boucle for pour implémenter le bon nombre de choix
        $nom = $res['designation'];
        echo("<option> $nom ");
            $res = pg_fetch_array($query);
            }?>
     </select>
    <input type="submit" value="Ajouter" name="ajout">
</form>

    
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script src="js/jquery.localscroll.js"></script>
<script src="js/jquery.scrollTo.js"></script>
<script src="js/bootstrap.min.js"></script>  
</body>
</html>