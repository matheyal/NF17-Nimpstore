<?php session_start();
if (isset($_SESSION['login']))
    $login=$_SESSION['login'];
else{
    session_destroy();
    $login=NULL;
}
?>

<?php
if (isset($_POST['ajout'])){
    include("idConnex.php");
    $num=$_POST['num_serie'];
    $modele=$_POST['modele'];
    
    $querystring="SELECT numero_serie FROM terminal t WHERE t.numero_serie='$num'";
    $query=pg_query($idConnex,$querystring);
    $res=pg_fetch_array($query);
    if (!is_null($res['numero_serie'])){
    }
    else{
    
    $querystring="SELECT m.id as mid,os.id as osid FROM modele m INNER JOIN systeme_exploitation os ON m.os=os.id
                    WHERE m.designation='$modele'";
    $query=pg_query($idConnex,$querystring);
    $res=pg_fetch_array($query);
    $mid=$res['mid'];
    
    $query=pg_query("INSERT INTO terminal VALUES ('$num','$mid','$login')")
            or die("erreur lors de l'insertion, contacter l'administrateur");

    header("Location:index.php");
    }
    
}
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

<h1>Vos Terminaux <?php echo $login; ?></h1>

<?php 
$querystring="SELECT R1.numero_serie,m.designation,m.os FROM (client c INNER JOIN terminal t ON c.login=t.proprietaire)R1
                INNER JOIN modele m ON R1.modele=m.id
                WHERE R1.login='$login'";//Requete du turfu by LeLu #checkdisout
$query=pg_query($idConnex,$querystring);
$res=pg_fetch_array($query);

if (is_null($res['designation'])){
echo "<p>Vous n'avez pas encore renseigné d'informations concernant vos appareils! Vous pourrez bientôt en ajouter autrement qu'en demandant à Alexis Mathey de modifier les tables ! #comingsoon</p>";
}else{
    while(!is_null($res['designation'])){
        echo "<p>Modèle : ".$res['designation']."</p>";
        echo "<p>N° Série : ".$res['numero_serie']."</p>";
        echo "</br>";
        /*$ter = new terminal($res['designation'],$res['os'],$res['numero_serie']); 
        $ter->afficher();*/
        $res=pg_fetch_array($query);
    }
}
?>

<h1>Ajouter un terminal</h1>
<p>Remplissez le formulaire ci-dessous pour ajouter un nouveau terminal. Vous pourrez ainsi télécharger et installer vos applications favorites sur celui-ci !</p>
<form method="post" action="mesTerminaux.php">
    <input type="text" name="num_serie" placeholder="N° Serie" required>
    <select name="modele" required>
    <option disabled>Modèle</option>
    <option disabled>──────────</option>
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